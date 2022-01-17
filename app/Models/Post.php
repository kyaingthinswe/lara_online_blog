<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    //Eager Loading
    protected $with = ['user','category','photos','tags'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function photos(){
        return $this->hasMany(Photo::class);
    }
    public function tags(){
        return $this->belongsToMany(Tag::class);
    }
    //Accessor
    //ရှိတဲ့ column ထက် ကိုယ်ပိုင် name ပေးပြီး accessor လုပ်တာ အဆင်ပြေ

    //public function getTitleAttribute($value){
        //return Str::words($value,10);
    //}

    //ကိုယ်ပိုင် accessor ပေးရင် CamelCase နဲ့ ပေးပြီး ပြန်ခေါ်ချင်ရင် snakecase နဲ့ခေါ်ရ
    public function getShortTitleAttribute(){
        return Str::words($this->title,10);
    }

    public function getTimeAttribute(){
        return "
        <p class='mb-0 '>
            <i class='fas fa-calendar fa-fw'></i>
            ".$this->created_at->format('Y-d-m')."
        </p>

        <p class='mb-0'>
            <i class='fas fa-clock fa-fw'></i>
            ".$this->created_at->format('H:m a')."
        </p>
        ";
    }

    //Mutator
    public function setSlugAttribute($value){
        $this->attributes['slug'] = Str::slug($value);
    }



    //query scope->local scope
    public function scopeSearch($query){
        $search = request()->search;
        $query->where('title','LIKE',"%$search%");
    }



}
