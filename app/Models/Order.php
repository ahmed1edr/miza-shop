<?
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // الخانات لي مسموح لينا نعمروهم
    protected $fillable = [
        'client_id', 'user_id', 'order_number', 'total_amount',
        'status', 'payment_method', 'delivery_address'
    ];

    // العلاقة 1: الطلبية تابعة لكليان واحد
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // العلاقة 2: الطلبية كياكدها موظف واحد
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // العلاقة 3: الطلبية فيها بزاف ديال التفاصيل 
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
