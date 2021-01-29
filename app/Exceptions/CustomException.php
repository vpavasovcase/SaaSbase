<?php

namespace App\Exceptions;

use App\Tools\CustomHelpers;
use Exception;
use Illuminate\Support\Facades\Config;
use Nuwave\Lighthouse\Exceptions\RendersErrorsExtensions;

class CustomException extends Exception implements RendersErrorsExtensions
{
    /**
     * @var @string
     */
    protected $reason;
    protected $code;

    public function __construct(string $message, string $reason = null, int $code = null)
    {
        parent::__construct($message);

        $this->reason = $reason;
        $this->code = $code;
    }

    /**
     * Returns true when exception message is safe to be displayed to a client.
     *
     * @api
     * @return bool
     */
    public function isClientSafe(): bool
    {
        return true;
    }

    /**
     * Returns string describing a category of the error.
     *
     * Value "graphql" is reserved for errors produced by query parsing or validation, do not use it.
     *
     * @api
     * @return string
     */
    public function getCategory(): string
    {
        return 'custom';
    }

    /**
     * Return the content that is put in the "extensions" part
     * of the returned error.
     *
     * @return array
     */
    public function extensionsContent(): array
    {

        $extra = [
            'reason' => $this->reason,
            'code' => $this->code,
        ];

        return $extra;
    }
}
