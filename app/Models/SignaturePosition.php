<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Signatory;

class SignaturePosition extends Model
{
    use HasFactory;

    /**
     *  declare model table
     *  @var string
     */
    protected $table = "signature_position";

    /**
     *  hidden fields
     *  @var array 
     */
    protected $hidden = [
        "created_at",
        "updated_at",
    ];

    /**
     *  declare accessible model fields
     *  @var array
     */
    protected $fillable = [
        "signatory_id",
        "template_image_id",
        "x",
        "y",
    ];

    /**
     *  define relationship with document_variation
     * 
     */
    public function signatory()
    {
        return $this->belongsTo(Signatory::class);
    }
}
