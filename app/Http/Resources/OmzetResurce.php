<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OmzetResurce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        $tgl_pembayaran_pembelian = '-';

        if ($this->jurnal->count() > 0) {
            $check = $this->jurnal->transaksi;
            //->where('invoice_external', '!=', '0') | ->where('kredit', '>', 0) |->whereIn('coa_id', [1, 5])->
            dd($check);
            if ($check) {
                dd($check);
                $tgl_pembayaran_pembelian = $check->tgl;
            }
        }
        return [
            //table invoice
            'id_invoice' => $this->id ?? '-',
            'id_nsfp' => $this->id_nsfp ?? '-',
            'id_transaksi' => $this->id_transaksi ?? '-',
            'invoice' => $this->invoice ?? '-',
            'harga' => $this->harga ?? '-',
            'jumlah' => $this->jumlah,
            'sub_total' => $this->sub_total ?? '-',
            'no' => $this->no ?? '-',
            'tgl_invoice' => $this->tgl_invoice ?? '-',
            'tgl_stuffing' => $this->Transaksi->SuratJalan->tgl_sj ?? '-',
            'nomor_sj' => $this->Transaksi->SuratJalan->nomor_surat ?? '-',
            'nomor_nsfp' => $this->NSFP->nomor ?? '-',
            'po_customer' => $this->Transaksi->SuratJalan->no_po,
            'customer' => $this->Transaksi->SuratJalan->Customer->nama ?? '-',
            'kota_cust' => $this->Transaksi->SuratJalan->Customer->kota,
            'nama_kapal' => $this->Transaksi->SuratJalan->nama_kapal ?? '-',
            'cont' => $this->Transaksi->SuratJalan->no_cont ?? '-',
            'seal' => $this->Transaksi->SuratJalan->no_seal ?? '-',
            'job' => $this->Transaksi->SuratJalan->no_job ?? '-',
            'nopol' => $this->Transaksi->SuratJalan->no_pol ?? '-',
            'nama_barang' => $this->Transaksi->Barang->nama ?? '-',
            'qty' => $this->Transaksi->jumlah_beli ?? '-',
            'satuan' => $this->Transaksi->satuan_beli ?? '-',
            'harga_jual' => $this->Transaksi->harga_jual ?? '-',
            'total_tagihan' => $this->Transaksi->jumlah_beli * $this->Transaksi->harga_jual ?? '-',
            'supplier' => $this->Transaksi->Suppliers->nama ?? '-',
            'harga_beli' => $this->Transaksi->harga_beli ?? '-',
            'total' => $this->Transaksi->harga_beli * $this->Transaksi->jumlah_beli ?? '-',
            'tgl_pembayaranpbl' => $tgl_pembayaran_pembelian,
            'no_vocherpbl' =>  '-', //$this->jurnal ? (($this->jurnal->invoice_external != 0 && $this->jurnal->coa_id == 5 || $this->jurnal->coa_id == 1) ? $this->jurnal->nomor : '-')  : '-',
            'harga_jual_ppn' => ($this->Transaksi->harga_jual + ($this->Transaksi->harga_jual * 0.11)) *  $this->Transaksi->jumlah_beli ?? '-',
            'harga_beli_ppn' => ($this->Transaksi->harga_beli + ($this->Transaksi->harga_beli * 0.11)) *  $this->Transaksi->jumlah_beli ?? '-',
            'margin_ppn' => (($this->Transaksi->harga_jual * 0.11) * $this->Transaksi->jumlah_beli) - (($this->Transaksi->harga_beli * 0.11) * $this->Transaksi->jumlah_beli) ?? '-',
            'margin' => ($this->Transaksi->harga_jual * $this->Transaksi->jumlah_beli) - ($this->Transaksi->harga_beli * $this->Transaksi->jumlah_beli) ?? '-',
            'margin_cek' => (($this->Transaksi->harga_jual + ($this->Transaksi->harga_jual * 0.11)) *  $this->Transaksi->jumlah_beli) - (($this->Transaksi->harga_beli + ($this->Transaksi->harga_beli * 0.11)) *  $this->Transaksi->jumlah_beli) - ((($this->Transaksi->harga_jual * 0.11) * $this->Transaksi->jumlah_beli) - (($this->Transaksi->harga_beli * 0.11) * $this->Transaksi->jumlah_beli)) ?? '-',
            'satuan_standar' => $this->Transaksi->Barang->Satuan->nama_satuan ?? '-',
            'beli' => ($this->Transaksi->satuan_beli == $this->Transaksi->Barang->Satuan->nama_satuan) ? $this->Transaksi->harga_beli : $this->Transaksi->harga_beli / $this->Transaksi->Barang->value ?? '-',
            'jual' => ($this->Transaksi->satuan_beli == $this->Transaksi->Barang->Satuan->nama_satuan) ? $this->Transaksi->harga_jual : $this->Transaksi->harga_jual / $this->Transaksi->Barang->value ?? '-'
        ];
    }
}
