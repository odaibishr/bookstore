<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Rating;  // استيراد موديل Rating

class StarRatingComponent extends Component
{
    public $value = 0; // التقييم الذي تم اختياره
    public $userId; // معرف المستخدم (يمكنك تمريره للمكون)
    public $bookId; // معرف المنتج (إذا كنت تستخدمه للتقييمات الخاصة بالمنتجات)

    public function setRating($value)
    {
        $this->value = $value;

        // حفظ التقييم في قاعدة البيانات
        $this->saveRating();
    }

    public function saveRating()
    {
        // تحقق مما إذا كان المستخدم قد قيم من قبل
        $existingRating = Rating::where('user_id', $this->userId)
            ->where('book_id', $this->bookId)
            ->first();

        if ($existingRating) {
            // إذا كان هناك تقييم سابق، تحديثه
            $existingRating->update(['value' => $this->value]);
        } else {
            // إذا لم يكن هناك تقييم سابق، إضافة تقييم جديد
            Rating::create([
                'user_id' => $this->userId,
                'book_id' => $this->bookId,
                'value' => $this->value
            ]);
        }
    }

    public function render()
    {
        return view('livewire.star-rating-component');
    }
}
