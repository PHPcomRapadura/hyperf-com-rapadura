<?php

declare(strict_types=1);

use Serendipity\Presentation\Output\Accepted;
use Serendipity\Presentation\Output\AlreadyReported;
use Serendipity\Presentation\Output\Created;
use Serendipity\Presentation\Output\Error\BadGateway;
use Serendipity\Presentation\Output\Error\GatewayTimeout;
use Serendipity\Presentation\Output\Error\InsufficientStorage;
use Serendipity\Presentation\Output\Error\InternalServerError;
use Serendipity\Presentation\Output\Error\LoopDetected;
use Serendipity\Presentation\Output\Error\NetworkAuthenticationRequired;
use Serendipity\Presentation\Output\Error\NotImplemented;
use Serendipity\Presentation\Output\Error\ProtocolVersionNotSupported;
use Serendipity\Presentation\Output\Error\ServiceUnavailable;
use Serendipity\Presentation\Output\Error\VariantAlsoNegotiates;
use Serendipity\Presentation\Output\Fail\BadRequest;
use Serendipity\Presentation\Output\Fail\Conflict;
use Serendipity\Presentation\Output\Fail\ExpectationFailed;
use Serendipity\Presentation\Output\Fail\FailedDependency;
use Serendipity\Presentation\Output\Fail\Forbidden;
use Serendipity\Presentation\Output\Fail\Gone;
use Serendipity\Presentation\Output\Fail\LengthRequired;
use Serendipity\Presentation\Output\Fail\Locked;
use Serendipity\Presentation\Output\Fail\MethodNotAllowed;
use Serendipity\Presentation\Output\Fail\Misdirected;
use Serendipity\Presentation\Output\Fail\NotAcceptable;
use Serendipity\Presentation\Output\Fail\NotFound;
use Serendipity\Presentation\Output\Fail\PayloadTooLarge;
use Serendipity\Presentation\Output\Fail\PaymentRequired;
use Serendipity\Presentation\Output\Fail\PreconditionFailed;
use Serendipity\Presentation\Output\Fail\PreconditionRequired;
use Serendipity\Presentation\Output\Fail\PropertiesAreTooLarge;
use Serendipity\Presentation\Output\Fail\ProxyAuthenticationRequired;
use Serendipity\Presentation\Output\Fail\RangeNotSatisfiable;
use Serendipity\Presentation\Output\Fail\RequestTimeout;
use Serendipity\Presentation\Output\Fail\TooEarly;
use Serendipity\Presentation\Output\Fail\TooMany;
use Serendipity\Presentation\Output\Fail\Unauthorized;
use Serendipity\Presentation\Output\Fail\UnavailableForLegalReasons;
use Serendipity\Presentation\Output\Fail\UnprocessableEntity;
use Serendipity\Presentation\Output\Fail\UnsupportedMediaType;
use Serendipity\Presentation\Output\Fail\UpdateRequired;
use Serendipity\Presentation\Output\ImUsed;
use Serendipity\Presentation\Output\MultiStatus;
use Serendipity\Presentation\Output\NoContent;
use Serendipity\Presentation\Output\NonAuthoritative;
use Serendipity\Presentation\Output\Ok;
use Serendipity\Presentation\Output\PartialContent;
use Serendipity\Presentation\Output\ResetContent;

return [
    'hosts' => [],
    'result' => [
        # #######################
        # # 2xx Success Output ##
        # #######################
        Ok::class => ['status' => 200],
        Created::class => ['status' => 201],
        Accepted::class => ['status' => 202],
        NonAuthoritative::class => ['status' => 203],
        NoContent::class => ['status' => 204],
        ResetContent::class => ['status' => 205],
        PartialContent::class => ['status' => 206],
        MultiStatus::class => ['status' => 207],
        AlreadyReported::class => ['status' => 208],
        ImUsed::class => ['status' => 226],
        # #######################
        # ## 4xx Client Error ###
        # #######################
        BadRequest::class => ['status' => 400],
        Unauthorized::class => ['status' => 401],
        PaymentRequired::class => ['status' => 402],
        Forbidden::class => ['status' => 403],
        NotFound::class => ['status' => 404],
        MethodNotAllowed::class => ['status' => 405],
        NotAcceptable::class => ['status' => 406],
        ProxyAuthenticationRequired::class => ['status' => 407],
        RequestTimeout::class => ['status' => 408],
        Conflict::class => ['status' => 409],
        Gone::class => ['status' => 410],
        LengthRequired::class => ['status' => 411],
        PreconditionFailed::class => ['status' => 412],
        PayloadTooLarge::class => ['status' => 413],
        UnsupportedMediaType::class => ['status' => 415],
        RangeNotSatisfiable::class => ['status' => 416],
        ExpectationFailed::class => ['status' => 417],
        Misdirected::class => ['status' => 421],
        UnprocessableEntity::class => ['status' => 422],
        Locked::class => ['status' => 423],
        FailedDependency::class => ['status' => 424],
        TooEarly::class => ['status' => 425],
        UpdateRequired::class => ['status' => 426],
        PreconditionRequired::class => ['status' => 428],
        TooMany::class => ['status' => 429],
        PropertiesAreTooLarge::class => ['status' => 431],
        UnavailableForLegalReasons::class => ['status' => 451],
        # #######################
        # ## 5xx Server Error ###
        # #######################
        InternalServerError::class => ['status' => 500],
        NotImplemented::class => ['status' => 501],
        BadGateway::class => ['status' => 502],
        ServiceUnavailable::class => ['status' => 503],
        GatewayTimeout::class => ['status' => 504],
        ProtocolVersionNotSupported::class => ['status' => 505],
        VariantAlsoNegotiates::class => ['status' => 506],
        InsufficientStorage::class => ['status' => 507],
        LoopDetected::class => ['status' => 508],
        NetworkAuthenticationRequired::class => ['status' => 511],
    ],
];
