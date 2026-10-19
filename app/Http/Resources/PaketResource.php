<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Fasilitas;
use App\Support\FileUrl;

class PaketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "documentId" => $this->documentId,
            "slug" => $this->slug,
            "name" => $this->name,
            "type" => $this->type,
            "description" => $this->description,
            "price" => (float) $this->price,
            "discountPrice" => $this->discount_price
                ? (float) $this->discount_price
                : null,
            "discountPercent" =>
                $this->discount_percent !== null
                    ? (float) $this->discount_percent
                    : null,
            "tanggalBerangkat" => $this->tanggal_berangkat?->format("Y-m-d"),
            "tanggalPulang" => $this->tanggal_pulang?->format("Y-m-d"),
            "durasiHari" => $this->durasi_hari,
            "quotaSeat" => $this->quota_seat,
            "sisaSeat" => $this->sisa_seat,
            "kotaKeberangkatan" => $this->kota_keberangkatan,
            "hotelRating" => $this->hotel_rating,
            "tipeKamar" => $this->tipe_kamar,
            "thumbnail" => FileUrl::from($this->thumbnail),
            "isFeatured" => $this->is_featured,
            "isPromo" => $this->is_promo,
            "aktif" => $this->aktif,

            // Detail relations (loaded when ?with_relations=1 or show)
            "fasilitas" => $this->whenLoaded(
                "fasilitasDetails",
                fn() => $this->fasilitasDetails->map(
                    fn($detail) => [
                        "id" => $detail->fasilitas->id,
                        "namaFasilitas" => $detail->fasilitas->nama_fasilitas,
                        "kategori" => $detail->fasilitas->kategori,
                    ],
                ),
            ),

            "fasilitasTidakTermasuk" => $this->when(
                $request->route("slug") !== null,
                fn() => $this->fasilitasTidakTermasuk(),
            ),

            "hotels" => $this->whenLoaded(
                "hotelDetails",
                fn() => $this->hotelDetails->map(
                    fn($detail) => [
                        "id" => $detail->hotel->id,
                        "namaHotel" => $detail->hotel->nama_hotel,
                        "lokasi" => $detail->hotel->lokasi,
                        "rating" => $detail->hotel->rating,
                        "deskripsi" => $detail->hotel->deskripsi_hotel,
                        "checkin" => $detail->checkin?->format("Y-m-d"),
                        "checkout" => $detail->checkout?->format("Y-m-d"),
                    ],
                ),
            ),

            "maskapais" => $this->whenLoaded(
                "maskapaiDetails",
                fn() => $this->maskapaiDetails->map(
                    fn($detail) => [
                        "id" => $detail->maskapai->id,
                        "namaMaskapai" => $detail->maskapai->nama_maskapai,
                        "keterangan" => $detail->maskapai->keterangan,
                        "nomorPenerbangan" => $detail->nomor_penerbangan,
                        "bandaraKeberangkatan" =>
                            $detail->bandara_keberangkatan,
                        "bandaraTujuan" => $detail->bandara_tujuan,
                        "waktuBerangkat" => $detail->waktu_berangkat?->toISOString(),
                        "waktuTiba" => $detail->waktu_tiba?->toISOString(),
                        "tipePenerbangan" => $detail->tipe_penerbangan,
                    ],
                ),
            ),

            "pembimbings" => $this->whenLoaded(
                "pembimbingDetails",
                fn() => $this->pembimbingDetails->map(
                    fn($detail) => [
                        "id" => $detail->pembimbing->id,
                        "namaPembimbing" =>
                            $detail->pembimbing->nama_pembimbing,
                        "kategori" => $detail->pembimbing->kategori,
                    ],
                ),
            ),

            "perjalanans" => $this->whenLoaded(
                "perjalananDetails",
                fn() => $this->perjalananDetails->map(
                    fn($detail) => [
                        "id" => $detail->perjalanan->id,
                        "lokasiPerjalanan" =>
                            $detail->perjalanan->lokasi_perjalanan,
                        "deskripsi" => $detail->perjalanan->deskripsi,
                        "tanggal" => $detail->tanggal?->format("Y-m-d"),
                    ],
                ),
            ),

            "createdAt" => $this->created_at?->toISOString(),
            "updatedAt" => $this->updated_at?->toISOString(),
            "publishedAt" => $this->published_at?->toISOString(),
        ];
    }

    /**
     * Master fasilitas for this package type that are not attached to the
     * package (category "umum" plus "umroh"/"haji" matching its type).
     */
    protected function fasilitasTidakTermasuk(): array
    {
        if (!$this->relationLoaded("fasilitasDetails")) {
            return [];
        }

        $selectedIds = $this->fasilitasDetails
            ->pluck("fasilitas_id")
            ->filter()
            ->all();

        $kategori =
            $this->type === "haji" ? ["umum", "haji"] : ["umum", "umroh"];

        return Fasilitas::query()
            ->where("aktif", true)
            ->whereIn("kategori", $kategori)
            ->whereNotIn("id", $selectedIds)
            ->orderBy("nama_fasilitas")
            ->get()
            ->map(
                fn(Fasilitas $fasilitas) => [
                    "id" => $fasilitas->id,
                    "namaFasilitas" => $fasilitas->nama_fasilitas,
                    "kategori" => $fasilitas->kategori,
                ],
            )
            ->values()
            ->all();
    }
}
