<?php

namespace App\Models;

use App\Helpers\RandomString;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    // Part of create link for create form
    const CREATE_URL = '/create-link';

    // Part of short link for routing
    const SHORT_LINK_URL = '/lnk/';

    // Attribute labels
    public static $LABELS = [
        'name' => 'Name',
        'url' => 'Url',
        'limit' => 'Limit',
        'valid_hours' => 'Limit time',
    ];

    protected $fillable = [
        'name',
        'url',
        'token',
        'limit',
        'valid_hours'
    ];

    protected $appends = [
        'short_link'
    ];

    public function getShortLinkAttribute(): string
    {
        return !empty($this->token) ? static::getShortLinkUrl($this->token) : '';
    }

    /**
     * Token validation.
     *
     * @return boolean
     */
    public function valid(): bool
    {
        if (empty($this->url) || $this->limit < 0)
            return false;

        // Valid by limit
        if ($this->limit !== 0) {
            $limit = $this->limit - 1;
            $limit = $limit == 0 ? -1 : $limit;
            $this->update([
                'limit' => $limit
            ]);
        }

        // Valid by life time
        $created_at = Carbon::createFromFormat('Y-m-d H:i:s',$this->created_at)->getTimestamp();
        $now = Carbon::now()->getTimestamp();
        $life_time = $this->valid_hours * 60 * 60;
        if ($created_at + $life_time < $now)
            return false;

        return true;
    }

    public function save(array $options = []): bool
    {
        // Autogenerate token for short link
        if (empty($this->token))
            $this->token = RandomString::getRandom(8);

        return parent::save($options);
    }

    /**
     * Default Link model for default form modal.
     *
     * @return static
     */
    public static function getDefaultLink(): Link
    {
        $link = new static();
        $link->limit = 0;
        $link->valid_hours = 24;

        return $link;
    }

    /**
     * Get part of short link with token.
     *
     * @param string $token
     * @return string
     */
    public static function getShortLinkUrl(string $token = ''): string
    {
        return static::SHORT_LINK_URL . $token;
    }

}
