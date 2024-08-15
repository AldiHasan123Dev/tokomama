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
            'npwp' => $this->transaksi->suratJalan->customer->npwp,
            'nik' => $this->transaksi->suratJalan->customer->nik,
            'nama' => $this->transaksi->suratJalan->customer->nama,
            'nama_npwp' => $this->transaksi->suratJalan->customer->nama_npwp,
            'alamat_npwp' => $this->transaksi->suratJalan->customer->alamat_npwp,
            'tujuan' => $this->transaksi->suratJalan->customer->nama,
            'uraian' => $this->transaksi->barang->nama,
            'faktur' => $this->nsfp->nomor,
            'subtotal' => $this->subtotal,
            'ppn' => $this->transaksi->barang->value_ppn . '%',
            'total' => $this->subtotal * 0.11,
            'none' => '-',
        ];
    }
}
