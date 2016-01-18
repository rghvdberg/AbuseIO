<?php namespace AbuseIO\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Ticket
 * @package AbuseIO\Models
 * @property integer $id guarded
 * @property string $ip
 * @property string $domain
 * @property integer $class_id
 * @property integer $type_id
 * @property string $email
 * @property string $ip_contact_account_id
 * @property string $ip_contact_reference
 * @property string $ip_contact_name
 * @property string $ip_contact_email
 * @property string $ip_contact_api_host
 * @property string $ip_contact_auto_notify
 * @property integer $ip_contact_notified_count
 * @property string $domain_contact_account_id
 * @property string $domain_contact_reference
 * @property string $domain_contact_name
 * @property string $domain_contact_email
 * @property string $domain_contact_api_host
 * @property string $domain_contact_auto_notify
 * @property integer $domain_contact_notified_count
 * @property integer $status_id
 * @property integer $account_id
 * @property boolean $auto_notify
 * @property integer $last_notify_count
 * @property integer $last_notify_timestamp
 * @property integer $created_at guarded
 * @property integer $updated_at guarded
 * @property integer $deleted_at guarded
 */
class Ticket extends Model
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table    = 'tickets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ip',
        'domain',
        'class_id',
        'type_id',
        'ip_contact_account_id',
        'ip_contact_reference',
        'ip_contact_name',
        'ip_contact_email',
        'ip_contact_api_host',
        'ip_contact_auto_notify',
        'ip_contact_notified_count',
        'domain_contact_account_id',
        'domain_contact_reference',
        'domain_contact_name',
        'domain_contact_email',
        'domain_contact_api_host',
        'domain_contact_auto_notify',
        'domain_contact_notified_count',
        'status_id',
        'last_notify_count',
        'last_notify_timestamp'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    /**
     * The attributes that cannot be changed
     *
     * @var array
     */
    protected $guarded  = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Validation rules for this model being created
     *
     * @return array $rules
     */
    public static function createRules()
    {
        $rules = [
            'ip'                                => 'required|ip',
            'domain'                            => 'sometimes|string',
            'class_id'                          => 'required|integer|min:100|max:999',
            'type_id'                           => 'required|integer|min:1|max:3',
            'ip_contact_account_id'             => 'required|integer',
            'ip_contact_reference'              => 'required|string',
            'ip_contact_name'                   => 'required|string',
            'ip_contact_email'                  => 'sometimes|emails',
            'ip_contact_api_host'               => 'sometimes|string',
            'ip_contact_auto_notify'            => 'required|boolean',
            'ip_contact_notified_count'         => 'required|integer',
            'domain_contact_account_id'         => 'required|integer',
            'domain_contact_reference'          => 'required|string',
            'domain_contact_name'               => 'required|string',
            'domain_contact_email'              => 'sometimes|emails',
            'domain_contact_api_host'           => 'sometimes|string',
            'domain_contact_auto_notify'        => 'required|boolean',
            'domain_contact_notified_count'     => 'required|integer',
            'status_id'                         => 'required|integer|min:1|max:5',
            'last_notify_count'                 => 'required|integer',
            'last_notify_timestamp'             => 'required|timestamp',
        ];

        return $rules;
    }

    /**
     * Validation rules for this model being updated
     *
     * @return array $rules
     */
    public static function updateRules()
    {
        $rules = [
            'ip'                                => 'required|ip',
            'domain'                            => 'sometimes|string',
            'class_id'                          => 'required|integer|min:100|max:999',
            'type_id'                           => 'required|integer|min:1|max:3',
            'ip_contact_account_id'             => 'required|integer',
            'ip_contact_reference'              => 'required|string',
            'ip_contact_name'                   => 'required|string',
            'ip_contact_email'                  => 'sometimes|emails',
            'ip_contact_api_host'               => 'sometimes|string',
            'ip_contact_auto_notify'            => 'required|boolean',
            'ip_contact_notified_count'         => 'required|integer',
            'domain_contact_account_id'         => 'required|integer',
            'domain_contact_reference'          => 'required|string',
            'domain_contact_name'               => 'required|string',
            'domain_contact_email'              => 'sometimes|emails',
            'domain_contact_api_host'           => 'sometimes|string',
            'domain_contact_auto_notify'        => 'required|boolean',
            'domain_contact_notified_count'     => 'required|integer',
            'status_id'                         => 'required|integer|min:1|max:5',
            'last_notify_count'                 => 'required|integer',
            'last_notify_timestamp'             => 'required|timestamp',
        ];

        return $rules;
    }

    /**
     * @return mixed
     */
    public function events()
    {

        return $this->hasMany('AbuseIO\Models\Event')
            ->orderBy('timestamp', 'desc');

    }

    /**
     * @return mixed
     */
    public function unreadNotes()
    {

        return $this->hasMany('AbuseIO\Models\Note')
            ->where('viewed', 'false');

    }

    /**
     * @return mixed
     */
    public function firstEvent()
    {

        return $this->hasMany('AbuseIO\Models\Event')
            ->orderBy('timestamp', 'asc')
            ->take(1);

    }

    /**
     * @return mixed
     */
    public function lastEvent()
    {

        return $this->hasMany('AbuseIO\Models\Event')
            ->orderBy('timestamp', 'desc')
            ->take(1);

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notes()
    {

        return $this->hasMany('AbuseIO\Models\Note');

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function accountIp()
    {

        return $this->belongsTo('AbuseIO\Models\Account', 'ip_contact_account_id');

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function accountDomain()
    {

        return $this->belongsTo('AbuseIO\Models\Account', 'domain_contact_account_id');

    }

    /*
    |--------------------------------------------------------------------------
    | Accessors & Mutators
    |--------------------------------------------------------------------------
    */

    /**
     * @return bool|string
     */
    public function getLastNotifiedAttribute()
    {
        return date(
            config('app.date_format').' ' . config('app.time_format'),
            $this->attributes['last_notify_timestamp']
        );
    }

    /**
     * @param $date
     * @return bool|string
     */
    public function getUpdatedAtAttribute($date)
    {
        return date(
            config('app.date_format').' ' .config('app.time_format'),
            strtotime($date)
        );
    }

    /**
     * @param $date
     * @return bool|string
     */
    public function getCreatedAtAttribute($date)
    {
        return date(
            config('app.date_format').' '.config('app.time_format'),
            strtotime($date)
        );
    }
}
