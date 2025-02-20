<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TItemRequest extends Model {
    use HasFactory, SoftDeletes;

    protected $table = 't_item_requests'; // Nama tabel

    public function scopeFilterByRole($query) {
        $user = auth()->user();
    
        if ($user && $user->hasRole('admin')) {
            // Periksa apakah ada parameter showSoftDeleted di URL
            if (request()->has('showSoftDeleted') && request()->get('showSoftDeleted') == 1) {
                return $query->withTrashed(); // Tampilkan semua data, termasuk yang dihapus
            } else {
                return $query->whereNull('deleted_at'); // Hanya tampilkan yang belum dihapus
            }
        } else {
            return $query->whereNull('deleted_at'); // User biasa hanya melihat data aktif
        }
    }
    
    

    // public function scopeFilterByRole($query) {
    //     if (auth()->user() && auth()->user()->hasRole('admin')) {
    //         return $query->withTrashed(); // Admin bisa melihat semua data
    //     } else {
    //         return $query->whereNull('deleted_at'); // User biasa hanya melihat data yang belum dihapus
    //     }
    // }
    
}
