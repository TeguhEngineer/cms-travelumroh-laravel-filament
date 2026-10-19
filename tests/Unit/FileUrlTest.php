<?php

namespace Tests\Unit;

use App\Support\FileUrl;
use Tests\TestCase;

class FileUrlTest extends TestCase
{
    public function test_blank_paths_return_null(): void
    {
        $this->assertNull(FileUrl::from(null));
        $this->assertNull(FileUrl::from(""));
        $this->assertNull(FileUrl::from("   "));
    }

    public function test_relative_public_disk_path_is_prefixed_with_storage(): void
    {
        $this->assertSame(
            asset("storage/paket-thumbnails/foto.png"),
            FileUrl::from("paket-thumbnails/foto.png"),
        );

        $this->assertSame(
            asset("storage/paket-thumbnails/foto.png"),
            FileUrl::from("/paket-thumbnails/foto.png"),
        );
    }

    public function test_absolute_urls_pass_through_unchanged(): void
    {
        $url = "https://picsum.photos/seed/asella/1200/800";
        $this->assertSame($url, FileUrl::from($url));

        $this->assertSame(
            "http://example.test/storage/x.png",
            FileUrl::from("http://example.test/storage/x.png"),
        );

        $this->assertSame(
            "//cdn.example.test/x.png",
            FileUrl::from("//cdn.example.test/x.png"),
        );
    }

    public function test_paths_already_including_storage_are_not_double_prefixed(): void
    {
        $this->assertSame(
            asset("storage/paket-thumbnails/foto.png"),
            FileUrl::from("storage/paket-thumbnails/foto.png"),
        );
    }
}
