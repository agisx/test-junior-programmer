<?php

use Livewire\WithPagination;
use Livewire\Volt\Component;
use App\Models\Produk;
use App\Models\Status;
use App\Models\Kategori;

use Mary\Traits\Toast;

new class extends Component {
    use WithPagination;

    // Use this trait 
    use Toast;

    public $modal_insert = false;
    public $modal_update = false;

    public $status_id_default = 1;

    public $nama_produk = "";
    public $harga = 0;
    public $kategori_id = 0;
    public $status_id = 0;
    
    public $produk_edit = null;
    public $nama_produk_edit = "";
    public $harga_edit = 0;
    public $kategori_id_edit = 0;
    public $status_id_edit = 0;

    public function status_id_change($value = 1){
        $this->status_id_default = $value;
    }

    public function delete($id_produk){
        Produk::find($id_produk)->delete();
        $this->success("Berhasil menghapus");
    }

    public function edit($id_produk){
        $produk = Produk::find($id_produk);
        if (!$produk) {
            return $this->info("Data tidak ditemukan");
        }
        $this->produk_edit = $produk;

        $this->nama_produk_edit = $produk->nama_produk;
        $this->harga_edit = $produk->harga;
        $this->kategori_id_edit = $produk->kategori_id;
        $this->status_id_edit = $produk->status_id;

        $this->modal_update = true;
    }

    public function edit_cancel(){
        $this->produk_edit = null;

        $this->modal_update = false;
    }
    
    public function update()
    {
        $validated = $this->validate([ 
            'nama_produk_edit' => 'required|string|max:255',
            'harga_edit' => 'required|integer|gte:0',
            'kategori_id_edit' => 'required|exists:kategori,id_kategori',
            'status_id_edit' => 'required|exists:status,id_status',
        ]);

        $this->produk_edit->nama_produk = $validated['nama_produk_edit'];
        $this->produk_edit->harga = $validated['harga_edit'];
        $this->produk_edit->kategori_id = $validated['kategori_id_edit'];
        $this->produk_edit->status_id = $validated['status_id_edit'];
 
        $this->produk_edit->save();

        $this->reset(
            'produk_edit',
            'nama_produk_edit',
            'harga_edit',
            'kategori_id_edit',
            'status_id_edit',
        ); 
 
        $this->modal_update = false;
        $this->success("Berhasil mengubah");
    }

    public function insert()
    {
        $validated = $this->validate([ 
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|integer|gte:0',
            'kategori_id' => 'required|exists:kategori,id_kategori',
            'status_id' => 'required|exists:status,id_status',
        ]);
 
        Produk::create($validated);

        $this->reset(
            'nama_produk',
            'harga',
            'kategori_id',
            'status_id',
        ); 
 
        $this->modal_insert = false;
        $this->success("Berhasil menambahkan");
    }

    public function with(): array
    {
        return [
            'produks' => Produk::
            when($this->status_id_default, function($q, $status_id_default){
                return $q->where('status_id', $status_id_default);
            })
            ->with(['kategori', 'status'])
            ->paginate(10),

            'statuses' => Status::get(),
            
            'kategoris' => Kategori::get(),
        ];
    }
}; ?>

@php
    $headers = [
        ['key' => 'id_produk', 'label' => '#'],
        ['key' => 'nama_produk', 'label' => 'Nama'],
        ['key' => 'harga', 'label' => 'Harga'],
        ['key' => 'kategori.nama_kategori', 'label' => 'Kategori'],
        ['key' => 'status.nama_status', 'label' => 'Status'],
    ];
@endphp

<div>
    <x-mary-modal wire:model="modal_insert" persistent>
        <x-mary-form wire:submit="insert">
            <p class="font-medium text-center">Tambah Produk</p>
            <x-mary-input label="Nama" wire:model="nama_produk" first-error-only />
            <x-mary-input label="Harga" type="number" wire:model="harga" first-error-only />
            
            <x-mary-select label="Pilih kategori" 
            :options="$kategoris" 
            option-value="id_kategori"
            option-label="nama_kategori"
            placeholder="Pilih kategori"
            placeholder-value="0"
            wire:model="kategori_id" 
            first-error-only
            />

            <x-mary-select label="Pilih status" 
            :options="$statuses" 
            option-value="id_status"
            option-label="nama_status"
            placeholder="Pilih status"
            placeholder-value="0"
            wire:model="status_id" 
            first-error-only
            />
         
            <x-slot:actions>
                <x-mary-button label="Batalkan" @click="$wire.modal_insert = false" />
                <x-mary-button label="Simpan" class="btn-primary" type="submit" spinner="insert" />
            </x-slot:actions>
        </x-mary-form>
    </x-mary-modal>

    <x-mary-modal wire:model="modal_update" persistent>
        <x-mary-form wire:submit="update">
            <p class="font-medium text-center">Edit Produk</p>
            <x-mary-input label="Nama" wire:model="nama_produk_edit" first-error-only />
            <x-mary-input label="Harga" type="number" wire:model="harga_edit" first-error-only />
            
            <x-mary-select label="Pilih kategori" 
            :options="$kategoris" 
            option-value="id_kategori"
            option-label="nama_kategori"
            placeholder="Pilih kategori"
            placeholder-value="0"
            wire:model="kategori_id_edit" 
            first-error-only
            />

            <x-mary-select label="Pilih status" 
            :options="$statuses" 
            option-value="id_status"
            option-label="nama_status"
            placeholder="Pilih status"
            placeholder-value="0"
            wire:model="status_id_edit" 
            first-error-only
            />
         
            <x-slot:actions>
                <x-mary-button label="Batalkan" @click="$wire.edit_cancel()" />
                <x-mary-button label="Simpan Perubahan" class="btn-primary" type="submit" spinner="update" />
            </x-slot:actions>
        </x-mary-form>
    </x-mary-modal>
    
    <x-mary-button label="Tambah" class="btn-primary" @click="$wire.modal_insert = true" />

    <x-mary-dropdown label="Filter" class="btn-outline" >
        <x-mary-menu-item title="Semua" wire:click='status_id_change(0)' />
        <x-mary-menu-item title="Bisa Dijual" wire:click='status_id_change(1)' />
        <x-mary-menu-item title="Tidak Bisa Dijual" wire:click='status_id_change(2)' />
    </x-mary-dropdown>

    {{-- <x-mary-table 
    :headers="$headers"
    :rows="$produks" 
    with-pagination
    show-empty-text
    /> --}}

    <x-mary-table 
    :headers="$headers"
    :rows="$produks"
    with-pagination
    show-empty-text
    >
    @scope('actions', $produk)
        <div class="grid grid-rows-2 gap-1 my-1">
            <x-mary-button icon="o-pencil" 
            wire:click="edit({{ $produk->id_produk }})" 
            spinner 
            class="btn-sm" />

            <x-mary-button icon="o-trash" 
            wire:click="delete({{ $produk->id_produk }})" 
            wire:confirm="Apa yakin ingin menghapus produk {{$produk->nama_produk}} ?"
            spinner 
            class="btn-sm" />
        </div>
    @endscope
    </x-mary-table>
</div>
