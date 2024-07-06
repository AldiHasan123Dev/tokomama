<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuratJalanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'invoice' => $this->invoice,
            'tgl_invoice' => $this->tgl_invoice,
            'nomor_surat' => $this->nomor_surat,
            'kepada' => $this->kepada,
            'jumlah' => $this->jumlah,
            'jumlah_satuan' => $this->jumlah_satuan,
            'total' => $this->total,
            'satuan' => $this->satuan,
            'jenis_barang' => $this->jenis_barang,
            'nama_kapal' => $this->nama_kapal,
            'no_cont' => $this->no_cont,
            'no_seal' => $this->no_seal,
            'no_pol' => $this->no_pol,
            'no_job' => $this->no_job,
            'tujuan' => $this->tujuan,
            'status' => $this->status,
            'harga_beli' => $this->harga_beli,
            'harga_jual' => $this->harga_jual,
            'profit' => $this->provit,
            'kota_pengirim' => $this->kota_pengirim,
            'nama_pengirim' => $this->nama_pengirim,
            'nama_penerima' => $this->nama_penerima,
            'no' => $this->no,
            'nama_customer' => $this->customer->nama ?? '-',
            'nama_npwp' => $this->customer->nama_npwp ?? '-',
            'npwp' => $this->customer->npwp ?? '-',
            'nik' => $this->customer->nik ?? '-',
            'email' => $this->customer->email ?? '-',
            'no_telp' => $this->customer->no_telp ?? '-',
            'alamat' => $this->customer->alamat ?? '-',
            'alamat_npwp' => $this->customer->alamat_npwp ?? '-',
            'nomor_nsfp' => $this->nsfp->nomor ?? '-',
            'keterangan' => $this->nsfp->keterangan ?? '-',
            'ppn' => '-',
            'total_all' => '-',
            'pph' => '-',
            'job' => '-',
            'no_bupot' => '-',
            'masa_pajak' => '-',
            'bupot' => '-',
            'tanggal_bupot' => '-',
            'selisih_bupot' => '-',
            'jurnal_bupot' => '-',
            'sub_total' => '-'

        ];
    }
}
