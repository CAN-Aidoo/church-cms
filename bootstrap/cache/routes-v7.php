<?php

/*
|--------------------------------------------------------------------------
| Load The Cached Routes
|--------------------------------------------------------------------------
|
| Here we will decode and unserialize the RouteCollection instance that
| holds all of the route information for an application. This allows
| us to instantaneously load the entire route map into the router.
|
*/

app('router')->setCompiledRoutes(
    array (
  'compiled' => 
  array (
    0 => false,
    1 => 
    array (
      '/sanctum/csrf-cookie' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'sanctum.csrf-cookie',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/_ignition/health-check' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ignition.healthCheck',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/_ignition/execute-solution' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ignition.executeSolution',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/_ignition/update-config' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ignition.updateConfig',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/login' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::VicvQSe5A1PtGL1G',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/register' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::8Sk4VnU2GjWGuglg',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/forgot-password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::xo1NI3kY3kQRKI9Y',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/reset-password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::MfS2QQLcsu6BT3IF',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/user' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::26bZrjyFdSfVCjMP',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/logout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::XYvASMBvRdZZVZcJ',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/dashboard/stats' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::neogY3HtZzLVqQOb',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/dashboard/charts' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::hq4UixyGgxBMTZDr',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/dashboard/recent-activity' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::CkBSoDITdBKgHC2n',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/notifications' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::XLBJ504xtIiJqEYn',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/notifications/unread' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::YC6xSv12a5Io79nm',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/notifications/unread-count' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::qCiyJ1C0REjsJ0Pp',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/notifications/mark-all-read' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::p95LUfdONzjQS2sY',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/my/profile' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::7fwRkeN9PgNcya1t',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::YA9DESLcNjnrAcQ8',
          ),
          1 => NULL,
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/my/attendance' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::FHd5rtS1CGyaTQ1U',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/my/contributions' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::4ln8xV5f9Btmss0w',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/my/programs' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::sb5BSkNMtstN5LbE',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/my/ministry' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::G1H8VWS1wSXKm9a3',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/my/shepherd' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Bq6kXYBSna0Hrfq5',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/my/family' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Ygin5HrG2YF61A8M',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/my/documents' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Bw4tE8zAjfzlBvVr',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/my/upcoming-events' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::WV7ofwoyZw9es8Jf',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/members' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::WqRhZcGIy4Zeyj9x',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::fdUQ5QSWfAx86H3l',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/members/search' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::SJwNCEzcV0yDNQga',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/members/statistics' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::srkZZihAgwaGTZTp',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/members/export' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::P568hxxw0Bv4QH1N',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/attendance' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::KzQRB3IWu7E3YyGp',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::2uY1WQH4iqcBssRz',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/attendance/bulk' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::TWwmCAKsL3RsQkJQ',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/attendance/reports' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ldS7HpLlb04qkmQS',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/attendance/leaderboard' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::FcZEzVQoBtzQJjZw',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/attendance/export' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::5FcJgMJ8jFEZ6Fqc',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/transactions' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::9Qa0bYgdoTYuLIhT',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::9jLVhdqs33aMOBRD',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/transactions/reports' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::wk5hwT2GszVes103',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/transactions/export' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::itQ8GckaVcVbcF9V',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/transactions/pending' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::e93plLueNC0oCCDA',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/transactions/analytics/dashboard-summary' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::KCR7yftnvxNMwt30',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/transactions/analytics/cash-flow' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::GqHJlWTPvwt9PBdz',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/transactions/analytics/budget-analysis' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Rfw4Fj4BF84XcCRV',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/transactions/analytics/giving-analytics' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::phSAxykoyo3L6KvP',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/transactions/analytics/expense-analytics' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::DBYWisryzU4hyyg0',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/transactions/analytics/forecasting' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::nubM8TCvh5xcNEGL',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/visitors' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::1nXq1b6wYasoMm5p',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::XKLyQKnkDCEtu9PW',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/visitors/eligible' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::znudFgU4q6rzNFgF',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/visitors/follow-up' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::mTGaZbnI72QTTzDr',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/visitors/reports' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::3WSEqTNc4ItNTYQU',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/sms' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::0o4gbUzKFGrF2MFh',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::OlTHSqmGD5MWD1aF',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/sms/templates/list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::eS8E0noqtfourFu3',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/sms/stats/delivery' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::NLhVMQpyc4cgukE2',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/sms/validate/phones' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::sLZsslKA0Kj4zOy3',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/sms/message/info' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::nVHAGJJnPhgsLUyq',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/programs' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::e1Tn71Z4FjRpVAqH',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::i7tiH1rNLoXyxJ8e',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/prayer/wall' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::VxaKfeUbtZqD3nlP',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/prayer/my-requests' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::K3j64XwyIlOTmKWo',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/prayer' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::FqpZt1zzJQ1HOfrd',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::aJAHoR9qKA7GIkEA',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/birthdays' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Hb5b9MWxbkYWx2cg',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/birthdays/calendar' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::DP9rMkbyXhs4GIhV',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/birthdays/history' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::UUSoGA7uQIJd0a2d',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/birthdays/milestones' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ZFtSrjQU10uJiyEa',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/birthdays/analytics' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::jTUTGdZ6aeBL0GXQ',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/birthdays/upcoming-celebrations' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::9BH3gLpy7EHuFaE0',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/birthdays/generate-announcements' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::HOIAPKt9dc9KP7XT',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/birthdays/test-workflow' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::WK6UvkmW6oTBwDCp',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/birthdays/schedule-preview' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::uTgcmwOG27ge07wB',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/birthdays/bulk-schedule' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::kmdvsuomQ8MC87DU',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/birthdays/recognition-suggestions' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::tZ4voLpBu7uMVBOc',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/birthdays/process' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ombvf5fT2ZO2zK7Q',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/birthdays/retry-failed' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::21j6WDwNhuoSxBJJ',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/reports' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::XQ7ZQrab0lf7d5QX',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/reports/analytics' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::aXeDjcf7fDBEldS3',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/reports/custom' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::VqVX7VDg6iQyQ7Tu',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/reports/preview' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::dFBhWxYp7VEyHMXL',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/reports/fields' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::GzGVJGMe0HTFXccv',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/reports/operators' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::7QnCGuBkwkl20uIq',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/reports/validate' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::PlJvbPUBFtPypPvn',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/reports/export/pdf' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::P9fu6eyQZbYNWWfw',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/reports/export/excel' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::6dtzOTsuBwyNUeIV',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/reports/export/csv' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::gh25j00rZxqCL28g',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/messaging/conversations' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::vK45O7aR9mU1zw7C',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/messaging/direct' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::U0NdikYENgvRiqGS',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/messaging/groups' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::BEescjevcBShXnU9',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/messaging/search' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::3U3YxllqFSeehKLH',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/shepherds' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::3UB0rQWAaHiXH7wB',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::vwehVFUqL37LYCQt',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/shepherds/analytics' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::7HSvh21VQzmMJZHY',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/shepherds/auto-assign' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::g9gL7tJhYxQf4tiN',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/service-units' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::FcLP23ltHSdfJYoW',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::pCuCMqpVJ3992FBh',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/service-units/analytics' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Bf9bNXVo7VoiXEmz',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/settings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::n6uTOequkvZCkRAC',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/settings/general' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Bb9Ljion96IcQcJO',
          ),
          1 => NULL,
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/settings/email-templates' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::3nh420LPDFHK1PXx',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/settings/audit-logs' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::15mH5fujrtBz03mC',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/settings/system-info' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::1oA35A5wTQFHXzrd',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/settings/clear-cache' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::bkpQx6viyZ6kH4vD',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/qr-management/dashboard' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::sN1gq0bDl09JB4vp',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/qr-management' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::404mVsZT9QBNGwpV',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::9FHoNenKu8xr6ulp',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/qr-management/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ztqUdzo4ctNoZbCK',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/qr-management/analytics/overview' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ks6sy3JihBwZC8VB',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/qr-management/settings/view' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::MOJQPQsa8OLq8xyw',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/qr-management/settings/update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::b1dwkgcFgiZJFCof',
          ),
          1 => NULL,
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/qr-management/print/preview' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::HR0ubjXyvYNLOuAJ',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/qr-management/batch/generate' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Xj5xFBpJfNoyDuGG',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/qr-scan/scan' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::4vnyJG1Dgo2PRik1',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/qr-scan/validate' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::vIVUwn26m38mY1q2',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/qr-scan/history' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::SLdesOihmzOVim21',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/qr-scan/sync-offline' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::3w5yCeNiJxhksxZk',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/qr-scan/active-service' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::2tsZthXBGRnnaEHb',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/mobile/v1/register/member' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::lAaLT5Dg0a2xD4Zn',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/mobile/v1/register/visitor' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::v41LRjPMi9tC2iTp',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/mobile/v1/verify-otp' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Zj77UdJaWEufTCSZ',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/mobile/v1/resend-otp' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::lAdq1n00vC3IhQT7',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/mobile/v1/check-in/member' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::TlMxqmyGeNg9Bowr',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/mobile/v1/check-in/service' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::IGoAW4JRWsiHQf5l',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/mobile/v1/check-in/family' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::iuw7Kj7GCE3q32Kn',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/mobile/v1/registration/status' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::z4pkq904KpXy8Rlv',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/mobile/v1/qr-code/personal' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::2jRBGrDuxCGuLekF',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/mobile/v1/payment/initiate' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::5CF6V5FZcDKqNgV1',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/mobile/v1/payment/verify' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::U2bxS7y4SIoINyN3',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/mobile/v1/payment/qr-details' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::dy53pni1zsQ3LGsl',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/mobile/v1/payment/recurring/setup' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::zaCjbBIFnFNbGnyo',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/mobile/v1/payment/history' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::tUfc4wsCezMh1MOq',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/mobile/v1/equipment/checkout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::VkhxwS5xF33Ur7Qh',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/mobile/v1/equipment/return' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::YhVEm2ckiiDb5d22',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/mobile/v1/equipment/my-checkouts' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::jIBCfWId9l8K8CoM',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/mobile/v1/equipment/report-issue' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Wdv6RuN9ByLZYjWM',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/mobile/v1/shepherd/flock' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::0KHHqbK0ia9cb84b',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/mobile/v1/shepherd/visit/record' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::u13AM8Q7EvvKG9fl',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/mobile/v1/shepherd/visit/history' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::42eN897Fu4Rmfaai',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/mobile/v1/shepherd/flock/message' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::84Y42DHnCLr4AGsT',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/mobile/v1/shepherd/performance' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::w0fW97tZwRZ8bzfK',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/mobile/v1/service-unit/my-units' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::aWOqfj63wRgaW81B',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/mobile/v1/children/check-in' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::UcYwwVAhWfwe7NsW',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/mobile/v1/children/check-out' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::sRAcDex2VVC1BGLj',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/mobile/v1/children/my-children' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::L2lEVrxX1wUaUa3J',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/mobile/v1/children/security-code/generate' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::0a9sXG4Zcd1l4D66',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/mobile/v1/children/incident/report' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::A2ZyDgsYTphUXt0H',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/mobile/v1/children/attendance-history' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::XyYMQMItYQrUXaS6',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/mobile/v1/announcements' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Evjjpvh2G8rdkoza',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/mobile/v1/service-times' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::wd6ceVIv1rMGe4ix',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/mobile/v1/church-info' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::jIhZIkb3wgLlwUoE',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/mobile/v1/events/upcoming' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::UVqvWVx0Qk1roGgK',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/mobile/v1/search' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::2xhGKLNuTSrFO8m7',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/mobile/v1/payment/callback' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.mobile.payment.callback',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::FGZzBfHE5d9bCGUP',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/login' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'login',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::45MJNujxKvJAZQfW',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/register' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'register',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::3Q9kQ5IQT11eVHqu',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/forgot-password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.request',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'password.email',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/reset-password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/logout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'logout',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/dashboard' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dashboard',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/dashboard/quick-action-data' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dashboard.quick-action-data',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/profile' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'profile',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'profile.update',
          ),
          1 => NULL,
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/notifications' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'notifications.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/notifications/unread' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'notifications.unread',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/notifications/mark-all-read' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'notifications.mark-all-read',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/members/statistics' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'members.statistics',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/members/export' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'members.export',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/members/search' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'members.search',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/members' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'members.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'members.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/members/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'members.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/attendance' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'attendance.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'attendance.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/attendance/mark' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'attendance.mark',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/attendance/bulk' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'attendance.bulk',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/attendance/reports' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'attendance.reports',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/attendance/export' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'attendance.export',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/attendance/leaderboard' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'attendance.leaderboard',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/attendance/live' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'attendance.live',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/attendance/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'attendance.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/transactions' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'transactions.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'transactions.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/transactions/reports' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'transactions.reports',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/transactions/export' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'transactions.export',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/transactions/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'transactions.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/visitors' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'visitors.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'visitors.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/visitors/eligible' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'visitors.eligible',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/visitors/follow-up' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'visitors.followUp',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/visitors/reports' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'visitors.reports',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/visitors/export' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'visitors.export',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/visitors/search' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'visitors.search',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/visitors/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'visitors.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/sms' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'sms.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'sms.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/sms/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'sms.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/equipment' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'equipment.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'equipment.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/equipment/maintenance' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'equipment.maintenance',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/equipment/reports' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'equipment.reports',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/equipment/export' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'equipment.export',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/equipment/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'equipment.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/shepherds' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'shepherds.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'shepherds.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/shepherds/analytics' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'shepherds.analytics',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/shepherds/export' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'shepherds.export',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/shepherds/auto-assign' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'shepherds.auto-assign',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/shepherds/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'shepherds.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/service-units' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'service-units.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'service-units.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/service-units/analytics' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'service-units.analytics',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/service-units/export' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'service-units.export',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/service-units/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'service-units.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/programs' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'programs.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'programs.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/programs/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'programs.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/services' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'services.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'services.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/services/calendar' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'services.calendar',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/services/sermon-library' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'services.sermon-library',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/services/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'services.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/prayer' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'prayer.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'prayer.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/prayer/analytics' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'prayer.analytics',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/prayer/testimonies' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'prayer.testimonies',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/prayer/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'prayer.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/prayer/testimonies/wall' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'prayer.testimonies-wall',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/birthdays' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'birthdays.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/birthdays/calendar' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'birthdays.calendar',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/birthdays/history' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'birthdays.history',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/birthdays/milestones' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'birthdays.milestones',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/birthdays/announcements' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'birthdays.announcements',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/birthdays/settings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'birthdays.settings',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/birthdays/process' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'birthdays.process',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/birthdays/retry-failed' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'birthdays.retry-failed',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/reports' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reports.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/reports/builder' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reports.builder',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/reports/custom' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reports.custom.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/reports/membership' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reports.membership.roster',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/reports/membership/new' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reports.membership.new',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/reports/membership/demographics' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reports.membership.demographics',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/reports/membership/birthdays' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reports.membership.birthdays',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/reports/financial' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reports.financial.income',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/reports/financial/expenses' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reports.financial.expenses',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/reports/financial/cash-flow' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reports.financial.cash-flow',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/reports/financial/giving' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reports.financial.giving',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/reports/attendance' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reports.attendance.summary',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/reports/attendance/trends' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reports.attendance.trends',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/reports/attendance/absentees' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reports.attendance.absentees',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/reports/program' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reports.program.performance',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/reports/program/impact' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reports.program.impact',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/reports/analytics' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reports.analytics',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/reports/schedules' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reports.schedules',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'reports.schedules.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/reports/executions' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reports.executions',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/reports/export/pdf' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reports.export.pdf',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/reports/export/excel' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reports.export.excel',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/reports/export/csv' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reports.export.csv',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/childrens-ministry' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'childrens-ministry.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/childrens-ministry/children' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'childrens-ministry.children',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/childrens-ministry/checkin' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'childrens-ministry.checkin',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'childrens-ministry.checkin.process',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/childrens-ministry/curriculum' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'childrens-ministry.curriculum',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'childrens-ministry.curriculum.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/childrens-ministry/curriculum/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'childrens-ministry.curriculum.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/childrens-ministry/events' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'childrens-ministry.events',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'childrens-ministry.events.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/childrens-ministry/events/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'childrens-ministry.events.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/childrens-ministry/reports' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'childrens-ministry.reports',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/settings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'settings.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/settings/general' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'settings.update-general',
          ),
          1 => NULL,
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/settings/email-templates' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'settings.email-templates',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/settings/audit-logs' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'settings.audit-logs',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/settings/backups' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'settings.backups',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'settings.create-backup',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/settings/system-info' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'settings.system-info',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/settings/clear-cache' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'settings.clear-cache',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/counselling' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'counselling.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/counselling/counsellors' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'counselling.counsellors',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'counselling.counsellors.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/counselling/counsellors/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'counselling.counsellors.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/counselling/sessions' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'counselling.sessions',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'counselling.sessions.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/counselling/sessions/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'counselling.sessions.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/counselling/available-counsellors' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'counselling.available-counsellors',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/counselling/cases' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'counselling.cases',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'counselling.cases.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/counselling/cases/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'counselling.cases.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/counselling/resources' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'counselling.resources',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'counselling.resources.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/counselling/resources/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'counselling.resources.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/counselling/reports' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'counselling.reports',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/welfare' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'welfare.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/welfare/cases' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'welfare.cases',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'welfare.cases.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/welfare/cases/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'welfare.cases.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/welfare/programs' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'welfare.programs',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'welfare.programs.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/welfare/programs/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'welfare.programs.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/welfare/fund-transactions' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'welfare.fund-transactions',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'welfare.record-transaction',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/welfare/reports' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'welfare.reports',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/messaging' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'messaging.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/messaging/direct' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'messaging.direct',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/messaging/groups' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'messaging.groups.create',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/messaging/starred' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'messaging.starred',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/messaging/search' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'messaging.search',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/messaging/block' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'messaging.block',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/messaging/unblock' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'messaging.unblock',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/messaging/blocked' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'messaging.blocked',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/media' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'media.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/media/content' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'media.content',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'media.content.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/media/streams' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'media.streams',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'media.streams.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/media/team' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'media.team',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/partnerships' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'partnerships.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/partnerships/partners' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'partnerships.partners',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'partnerships.partners.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/partnerships/agreements' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'partnerships.agreements',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'partnerships.agreements.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/qr-codes' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'qr-codes.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/qr-codes/service' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'qr-codes.service',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/qr-codes/member-registration' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'qr-codes.member-registration',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/qr-codes/visitor-registration' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'qr-codes.visitor-registration',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/qr-codes/payment' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'qr-codes.payment',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/qr-codes/personal' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'qr-codes.personal',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/qr-codes/bulk-download' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'qr-codes.bulk-download',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/qr-management/dashboard' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'qr-management.dashboard',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/qr-management' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'qr-management.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'qr-management.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/qr-management/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'qr-management.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/qr-management/analytics/overview' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'qr-management.analytics',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/qr-management/settings/view' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'qr-management.settings',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/qr-management/print/preview' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'qr-management.print',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mobile' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'mobile.home',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mobile/login' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'mobile.login',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mobile/register' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'mobile.register',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mobile/checkin' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'mobile.checkin',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mobile/service-checkin' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'mobile.service-checkin',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mobile/visitor-register' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'mobile.visitor-register',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mobile/member-register' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'mobile.member-register',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mobile/give' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'mobile.give',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mobile/payment' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'mobile.payment',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mobile/payment-success' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'mobile.payment-success',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mobile/church-info' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'mobile.church-info',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mobile/dashboard' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'mobile.dashboard',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mobile/profile' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'mobile.profile',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mobile/profile-edit' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'mobile.profile-edit',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mobile/settings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'mobile.settings',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mobile/giving' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'mobile.giving',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mobile/giving-history' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'mobile.giving-history',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mobile/events' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'mobile.events',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mobile/announcements' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'mobile.announcements',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mobile/attendance' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'mobile.attendance',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mobile/attendance-history' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'mobile.attendance-history',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mobile/children-ministry' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'mobile.children-ministry',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mobile/equipment-management' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'mobile.equipment-management',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mobile/shepherd/dashboard' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'mobile.shepherd.dashboard',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mobile/shepherd/record-visit' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'mobile.shepherd.record-visit',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mobile/shepherd/visit-history' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'mobile.shepherd.visit-history',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mobile/shepherd/message-flock' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'mobile.shepherd.message-flock',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mobile/shepherd/performance' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'mobile.shepherd.performance',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mobile/service-unit/dashboard' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'mobile.service-unit.dashboard',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mobile/service-unit/manage' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'mobile.service-unit.manage',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mobile/service-unit/roster' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'mobile.service-unit.roster',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mobile/service-unit/duty-tasks' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'mobile.service-unit.duty-tasks',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
    ),
    2 => 
    array (
      0 => '{^(?|/a(?|pi/(?|v1/(?|notifications/(?|([^/]++)(?|/mark\\-as\\-read(*:67)|(*:74))|preferences(?|(*:96)))|m(?|y/documents/([^/]++)/download(*:138)|e(?|mbers/(?|([^/]++)(?|(*:170)|/photo(?|(*:187)))|bulk\\-action(*:209))|ssaging/(?|conversations/([^/]++)(?|(*:254)|/m(?|essages(?|(*:277))|ark\\-read(*:295)))|messages/([^/]++)(?|(*:325)|/(?|reactions(*:346)|star(*:358))))))|attendance/([^/]++)(?|(*:393))|transactions/([^/]++)(?|(*:426)|/(?|approve(*:445)|reject(*:459))|(*:468))|visitors/([^/]++)(?|(*:497)|/(?|record\\-visit(*:522)|convert(*:537)))|s(?|ms/(?|([^/]++)(?|(*:568)|/s(?|end(*:584)|tatus(*:597)))|preview(*:614))|hepherds/([^/]++)(?|(*:643)|/(?|assign\\-member(*:669)|unassign\\-member(*:693)))|e(?|rvice\\-units/([^/]++)(?|(*:731)|/(?|add\\-member(*:754)|remove\\-member(*:776)))|ttings/email\\-templates/([^/]++)(*:818)))|pr(?|ograms/(?|([^/]++)(?|(*:854)|/(?|publish(*:873)|start(*:886)|c(?|omplete(*:905)|ancel(*:918))|registrations(*:940)))|registrations/([^/]++)/check\\-in(*:982)|([^/]++)/(?|analytics(*:1011)|register(*:1028)))|ayer/(?|([^/]++)(?|(*:1058))|analytics(*:1077)|([^/]++)/(?|a(?|ssign(*:1107)|dd\\-update(*:1126))|mark\\-answered(*:1150))|testimonies(*:1171)))|birthdays/milestones/([^/]++)/recognize(*:1221)|reports/custom/([^/]++)(?|(*:1256))|qr\\-(?|management/(?|([^/]++)(?|(*:1298)|/(?|revoke(*:1317)|extend(*:1332)|analytics(*:1350)|scan\\-logs(*:1369)))|export/analytics(*:1396))|scan/([^/]++)/(?|info(*:1427)|has\\-scanned(*:1448)|report(*:1463))))|mobile/v1/(?|e(?|quipment/scan/([^/]++)(*:1514)|vents/([^/]++)(*:1537))|service\\-unit/([^/]++)/(?|details(*:1580)|members(?|(*:1599))|rosters(?|(*:1619)))))|ttendance/([^/]++)(?|(*:1653)|/edit(*:1667)|(*:1676)))|/re(?|set\\-password/([^/]++)(*:1715)|ports/(?|custom/([^/]++)(?|(*:1751)|/(?|edit(*:1768)|duplicate(*:1786)|favorite(*:1803))|(*:1813))|schedules/([^/]++)(?|(*:1844))|executions/([^/]++)(?|/download(*:1885)|(*:1894))))|/notifications/(?|([^/]++)(?|/mark\\-as\\-read(*:1950)|(*:1959))|delete\\-all\\-read(*:1986)|preferences(?|(*:2009)))|/m(?|e(?|mbers/(?|([^/]++)(?|(*:2049)|/edit(*:2063)|(*:2072))|bulk\\-action(*:2094)|([^/]++)/photo(*:2117))|ssaging/(?|conversations/([^/]++)(?|(*:2163)|/(?|m(?|essages(?|(*:2190))|ark\\-read(*:2209))|archive(*:2226)|unarchive(*:2244)))|groups/([^/]++)(?|(*:2273)|/(?|participants(?|(*:2301))|leave(*:2316)))|messages/([^/]++)(?|(*:2347)|/(?|pin(?|(*:2366))|re(?|actions(?|(*:2391))|port(*:2405))|star(?|(*:2422)))))|dia/content/([^/]++)/publish(*:2463))|obile/(?|e(?|quipment/([^/]++)(*:2503)|vent\\-(?|details/([^/]++)(*:2537)|register/([^/]++)(*:2563)))|program\\-register/([^/]++)(*:2600)))|/transactions/(?|([^/]++)(?|(*:2639)|/(?|edit(*:2656)|receipt(*:2672))|(*:2682))|pending(*:2699)|([^/]++)(?|/(?|approve(*:2730)|reject(*:2745))|(*:2755)))|/visitors/([^/]++)(?|(*:2787)|/(?|edit(*:2804)|record\\-visit(*:2826)|convert(?|(*:2845))|mark\\-inactive(*:2869))|(*:2879))|/s(?|ms/([^/]++)(?|(*:2908)|/s(?|end(*:2925)|tatus(*:2939)))|hepherds/([^/]++)(?|(*:2970)|/(?|edit(*:2987)|m(?|anage\\-flock(*:3012)|eetings(?|(*:3031)))|assign\\-member(*:3056)|unassign\\-member(*:3081)|visitations(?|(*:3104))|create\\-(?|visitation(*:3135)|meeting(*:3151))|reports(*:3168))|(*:3178))|e(?|rvice(?|\\-units/([^/]++)(?|(*:3219)|/(?|edit(*:3236)|manage\\-members(*:3260)|add\\-member(*:3280)|remove\\-member(*:3303)|duty\\-rosters(?|(*:3328))|create\\-duty\\-roster(*:3358))|(*:3368))|s/(?|([^/]++)(?|(*:3394)|/(?|edit(*:3411)|publish(*:3427)|start(*:3441)|c(?|omplete(*:3461)|ancel(*:3475))|duplicate(*:3494)|worship\\-plan(?|(*:3519)))|(*:3530))|worship\\-plan/([^/]++)(?|(*:3565))|([^/]++)/(?|worship\\-plan/reorder(*:3608)|volunteers(?|(*:3630)))|volunteers/([^/]++)(?|(*:3663)|/confirm(*:3680))))|ttings/(?|email\\-templates/([^/]++)(?|/edit(*:3735)|(*:3744))|backups/([^/]++)(?|/download(*:3782)|(*:3791)))))|/equipment/([^/]++)(?|(*:3826)|/(?|edit(*:3843)|maintenance(?|\\-form(*:3872)|(*:3881))|schedule\\-maintenance(*:3912))|(*:3922))|/duty\\-rosters/([^/]++)/publish(*:3963)|/p(?|r(?|ograms/(?|([^/]++)(?|(*:4002)|/(?|edit(*:4019)|publish(*:4035)|start(*:4049)|c(?|omplete(*:4069)|ancel(*:4083))|registrations(*:4106))|(*:4116))|registrations/([^/]++)/check\\-in(*:4158)|([^/]++)/sessions(?|(*:4187))|sessions/([^/]++)(?|(*:4217))|([^/]++)/(?|analytics(*:4248)|register(?|(*:4268)))|registrations/([^/]++)/success(*:4309))|ayer/(?|([^/]++)/(?|a(?|ssign(*:4348)|dd\\-update(*:4367))|mark\\-answered(*:4391))|testimonies/([^/]++)/approve(*:4429)|([^/]++)(?|(*:4449)|/edit(*:4463)|(*:4472))|wall(*:4486)|my\\-(?|requests(*:4510)|assignments(*:4530))))|artnerships/agreements/([^/]++)/activate(*:4582))|/birthdays/(?|milestones/([^/]++)/recognize(*:4635)|announcements/([^/]++)/display(*:4674)|settings/([^/]++)(*:4700))|/c(?|hildrens\\-ministry/(?|c(?|h(?|ildren/([^/]++)(*:4760)|eckout/([^/]++)(*:4784))|urriculum/([^/]++)(?|(*:4815)|/(?|edit(*:4832)|publish(*:4848))|(*:4858)))|events/([^/]++)(?|(*:4887)|/(?|register(*:4908)|publish(*:4924)|start(*:4938)|complete(*:4955))))|ounselling/(?|c(?|ounsellors/([^/]++)(?|(*:5007)|/(?|activate(*:5028)|deactivate(*:5047)))|ases/([^/]++)(?|(*:5074)|/(?|activate(*:5095)|hold(*:5108)|close(*:5122))))|sessions/([^/]++)(?|(*:5154)|/(?|c(?|o(?|nfirm(*:5180)|mplete(*:5195))|ancel(*:5210))|start(*:5225)|reschedule(*:5244)))|resources/([^/]++)(?|(*:5276)|/download(*:5294))))|/welfare/(?|cases/([^/]++)(?|(*:5335)|/(?|under\\-review(*:5361)|verify(*:5376)|reject(?|\\-verification(*:5408)|(*:5417))|approve(*:5434)|close(*:5448)))|programs/([^/]++)(?|(*:5479)|/(?|activate(*:5500)|pause(*:5514)|complete(*:5531))))|/qr\\-(?|codes/(?|equipment/([^/]++)(*:5578)|program/([^/]++)(*:5603))|management/([^/]++)(?|(*:5635)|/(?|revoke(*:5654)|extend(*:5669)|image(*:5683)|download(*:5700)))))/?$}sDu',
    ),
    3 => 
    array (
      67 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::pZBu1je5nxyYclln',
          ),
          1 => 
          array (
            0 => 'notification',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      74 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::m9ie3JyANv78CL0R',
          ),
          1 => 
          array (
            0 => 'notification',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      96 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::qoahZ0kkJ6gFsMTr',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::LJhQIZGPj731O9pJ',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      138 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.member.documents.download',
          ),
          1 => 
          array (
            0 => 'documentId',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      170 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::th4nBobiynYXjpm5',
          ),
          1 => 
          array (
            0 => 'member',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::jRqEe82Sh4hxCTUr',
          ),
          1 => 
          array (
            0 => 'member',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'generated::eWYSyEvFEGMiWtkr',
          ),
          1 => 
          array (
            0 => 'member',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      187 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::RAf82BOUZunLzX6h',
          ),
          1 => 
          array (
            0 => 'member',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ZF3Cs1ABUtai7qgK',
          ),
          1 => 
          array (
            0 => 'member',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      209 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::tEvb4GX6WCj1App5',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      254 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::j3BUheD3BnIETYRM',
          ),
          1 => 
          array (
            0 => 'conversation',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      277 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::3qApRQhy9CBlFcmX',
          ),
          1 => 
          array (
            0 => 'conversation',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Vey2t0driASU2SpZ',
          ),
          1 => 
          array (
            0 => 'conversation',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      295 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::47Mny4nM1lYVakaU',
          ),
          1 => 
          array (
            0 => 'conversation',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      325 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::msE9RMwHzUTPdzzu',
          ),
          1 => 
          array (
            0 => 'message',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::rO8TmzV1yPKRfuPg',
          ),
          1 => 
          array (
            0 => 'message',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      346 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ORBp2yxQEts7WvVl',
          ),
          1 => 
          array (
            0 => 'message',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      358 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::CwiIBbsBclMHwLu2',
          ),
          1 => 
          array (
            0 => 'message',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      393 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::kLPXY7QHmXceiXaz',
          ),
          1 => 
          array (
            0 => 'attendance',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::2pwnGD66lfHPy3Wb',
          ),
          1 => 
          array (
            0 => 'attendance',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'generated::TZK32n0mumOxTnHh',
          ),
          1 => 
          array (
            0 => 'attendance',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      426 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::3XHGExUZ1BL83PCa',
          ),
          1 => 
          array (
            0 => 'transaction',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ssnKuw36K2Znp3w4',
          ),
          1 => 
          array (
            0 => 'transaction',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      445 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::S4MU2dfGT7rVwICi',
          ),
          1 => 
          array (
            0 => 'transaction',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      459 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::JkKPWSph6POYFRad',
          ),
          1 => 
          array (
            0 => 'transaction',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      468 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::9r71t9YCdCiJN8nV',
          ),
          1 => 
          array (
            0 => 'transaction',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      497 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::UNOSOuPNigdtPpHE',
          ),
          1 => 
          array (
            0 => 'visitor',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::OVLH82fMq3IkjzSV',
          ),
          1 => 
          array (
            0 => 'visitor',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'generated::W9bHhGupeX8MFLMZ',
          ),
          1 => 
          array (
            0 => 'visitor',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      522 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ptKSLktmIJVJz5zh',
          ),
          1 => 
          array (
            0 => 'visitor',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      537 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::uo8XOiwR0RZ5TEWe',
          ),
          1 => 
          array (
            0 => 'visitor',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      568 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::XoReF1ksp7pTn5CQ',
          ),
          1 => 
          array (
            0 => 'broadcast',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      584 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::EH7aSQIyiNLZljYJ',
          ),
          1 => 
          array (
            0 => 'broadcast',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      597 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::2SSzpYVZrcR4xst1',
          ),
          1 => 
          array (
            0 => 'broadcast',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      614 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::AvZD5FbL6zgRJilU',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      643 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::08Hn6rOhB8SgED1O',
          ),
          1 => 
          array (
            0 => 'shepherd',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::AxXQTn4KjJ2Rt0FV',
          ),
          1 => 
          array (
            0 => 'shepherd',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'generated::wMKoFlFh0O4FX54A',
          ),
          1 => 
          array (
            0 => 'shepherd',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      669 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::CTOPMReF3zzCV5b7',
          ),
          1 => 
          array (
            0 => 'shepherd',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      693 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::2fNEQJcKd8h08XJh',
          ),
          1 => 
          array (
            0 => 'shepherd',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      731 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::t0Aid19asZkxDmEw',
          ),
          1 => 
          array (
            0 => 'serviceUnit',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::EixZ41Qyn3uBHZeD',
          ),
          1 => 
          array (
            0 => 'serviceUnit',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'generated::cGFGsAOKTb8mlTZ8',
          ),
          1 => 
          array (
            0 => 'serviceUnit',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      754 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ODt1ttJMV7srDQop',
          ),
          1 => 
          array (
            0 => 'serviceUnit',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      776 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::l3rquiZKNka3QFCm',
          ),
          1 => 
          array (
            0 => 'serviceUnit',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      818 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::wBavoY17XhC5y6oo',
          ),
          1 => 
          array (
            0 => 'template',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      854 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::PYAoJ6vJj85iI5s4',
          ),
          1 => 
          array (
            0 => 'program',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::JzlOZX34u0ro9w9X',
          ),
          1 => 
          array (
            0 => 'program',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'generated::goaIOxu0dBA7y42T',
          ),
          1 => 
          array (
            0 => 'program',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      873 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::NZ9c8KeI3sjFDTnt',
          ),
          1 => 
          array (
            0 => 'program',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      886 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::5TWQpL43ydrqK6g0',
          ),
          1 => 
          array (
            0 => 'program',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      905 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::bRs9vq9Vc8rzWCTO',
          ),
          1 => 
          array (
            0 => 'program',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      918 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::MdabxQEnywoTqDlQ',
          ),
          1 => 
          array (
            0 => 'program',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      940 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::htqvgySh79bCJqFG',
          ),
          1 => 
          array (
            0 => 'program',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      982 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ZP6Mt3UJF8z3oBjE',
          ),
          1 => 
          array (
            0 => 'registration',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1011 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::devlhCiufnKfaXkn',
          ),
          1 => 
          array (
            0 => 'program',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1028 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::uuOsHYxKKR2Hz5Nt',
          ),
          1 => 
          array (
            0 => 'program',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1058 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::UQF7hu9fMtLQNH8v',
          ),
          1 => 
          array (
            0 => 'prayerRequest',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::S8K7dOEi2gqfig4p',
          ),
          1 => 
          array (
            0 => 'prayerRequest',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'generated::oI8QD2AXwnFLgtVf',
          ),
          1 => 
          array (
            0 => 'prayerRequest',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1077 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::x74zte1I0SFImQ9T',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1107 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::cEyTYb9IEfYWSCr6',
          ),
          1 => 
          array (
            0 => 'prayerRequest',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1126 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::uoTRKfnPks5QKl28',
          ),
          1 => 
          array (
            0 => 'prayerRequest',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1150 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ytQGgviJ3btrimSd',
          ),
          1 => 
          array (
            0 => 'prayerRequest',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1171 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::l6gCWjARRgP28NVq',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1221 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::gB4t5xadJ31ogbHs',
          ),
          1 => 
          array (
            0 => 'milestone',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1256 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::4pEH3eQ6wTMkllcT',
          ),
          1 => 
          array (
            0 => 'report',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::MJiSGzBxiYoSXYPR',
          ),
          1 => 
          array (
            0 => 'report',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'generated::cf0msSG69wXPWQnO',
          ),
          1 => 
          array (
            0 => 'report',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1298 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::bHEC9UA8WDu2x0Db',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1317 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::D8C1ACgrPoFWPXYG',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1332 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::CCYj6PCezawlbwVP',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1350 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::tXxrlngSSoQfIF10',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1369 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::8yaigQdAWxk8y4hW',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1396 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::7u6ay3APg7y2l1AK',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1427 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ytob8AOUgU1lR5kQ',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1448 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::H0muDMa3IdsIFr0T',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1463 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::0OvgFkrQuUYI5RYK',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1514 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::WPI3lU4LjzYKxlHi',
          ),
          1 => 
          array (
            0 => 'qrCode',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1537 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::M8cqAwNEXFzq4CiJ',
          ),
          1 => 
          array (
            0 => 'eventId',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1580 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::3SLv5M81WbV2TlHK',
          ),
          1 => 
          array (
            0 => 'serviceUnit',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1599 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::xCZzSFTEGrzYAeKE',
          ),
          1 => 
          array (
            0 => 'serviceUnit',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::mHRZdTnGc5Xq29Xp',
          ),
          1 => 
          array (
            0 => 'serviceUnit',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1619 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::OfdrZWaeMf8XtC7K',
          ),
          1 => 
          array (
            0 => 'serviceUnit',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::dIndZ6BARlIVpKXO',
          ),
          1 => 
          array (
            0 => 'serviceUnit',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1653 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'attendance.show',
          ),
          1 => 
          array (
            0 => 'attendance',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1667 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'attendance.edit',
          ),
          1 => 
          array (
            0 => 'attendance',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1676 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'attendance.update',
          ),
          1 => 
          array (
            0 => 'attendance',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'attendance.destroy',
          ),
          1 => 
          array (
            0 => 'attendance',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1715 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.reset',
          ),
          1 => 
          array (
            0 => 'token',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1751 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reports.custom.show',
          ),
          1 => 
          array (
            0 => 'report',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1768 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reports.custom.edit',
          ),
          1 => 
          array (
            0 => 'report',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1786 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reports.custom.duplicate',
          ),
          1 => 
          array (
            0 => 'report',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1803 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reports.custom.favorite',
          ),
          1 => 
          array (
            0 => 'report',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1813 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reports.custom.update',
          ),
          1 => 
          array (
            0 => 'report',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'reports.custom.delete',
          ),
          1 => 
          array (
            0 => 'report',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1844 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reports.schedules.update',
          ),
          1 => 
          array (
            0 => 'schedule',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'reports.schedules.delete',
          ),
          1 => 
          array (
            0 => 'schedule',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1885 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reports.executions.download',
          ),
          1 => 
          array (
            0 => 'execution',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1894 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reports.executions.delete',
          ),
          1 => 
          array (
            0 => 'execution',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1950 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'notifications.mark-as-read',
          ),
          1 => 
          array (
            0 => 'notification',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1959 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'notifications.destroy',
          ),
          1 => 
          array (
            0 => 'notification',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1986 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'notifications.delete-all-read',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2009 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'notifications.preferences',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'notifications.update-preferences',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2049 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'members.show',
          ),
          1 => 
          array (
            0 => 'member',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2063 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'members.edit',
          ),
          1 => 
          array (
            0 => 'member',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2072 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'members.update',
          ),
          1 => 
          array (
            0 => 'member',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'members.destroy',
          ),
          1 => 
          array (
            0 => 'member',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2094 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'members.bulk-action',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2117 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'members.delete-photo',
          ),
          1 => 
          array (
            0 => 'member',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2163 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'messaging.conversation',
          ),
          1 => 
          array (
            0 => 'conversation',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2190 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'messaging.conversation.messages',
          ),
          1 => 
          array (
            0 => 'conversation',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'messaging.messages.send',
          ),
          1 => 
          array (
            0 => 'conversation',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2209 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'messaging.conversation.mark-read',
          ),
          1 => 
          array (
            0 => 'conversation',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2226 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'messaging.conversation.archive',
          ),
          1 => 
          array (
            0 => 'conversation',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2244 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'messaging.conversation.unarchive',
          ),
          1 => 
          array (
            0 => 'conversation',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2273 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'messaging.groups.update',
          ),
          1 => 
          array (
            0 => 'conversation',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2301 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'messaging.groups.add-participants',
          ),
          1 => 
          array (
            0 => 'conversation',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'messaging.groups.remove-participant',
          ),
          1 => 
          array (
            0 => 'conversation',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2316 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'messaging.groups.leave',
          ),
          1 => 
          array (
            0 => 'conversation',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2347 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'messaging.messages.edit',
          ),
          1 => 
          array (
            0 => 'message',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'messaging.messages.delete',
          ),
          1 => 
          array (
            0 => 'message',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2366 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'messaging.messages.pin',
          ),
          1 => 
          array (
            0 => 'message',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'messaging.messages.unpin',
          ),
          1 => 
          array (
            0 => 'message',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2391 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'messaging.messages.react',
          ),
          1 => 
          array (
            0 => 'message',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'messaging.messages.unreact',
          ),
          1 => 
          array (
            0 => 'message',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2405 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'messaging.messages.report',
          ),
          1 => 
          array (
            0 => 'message',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2422 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'messaging.messages.star',
          ),
          1 => 
          array (
            0 => 'message',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'messaging.messages.unstar',
          ),
          1 => 
          array (
            0 => 'message',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2463 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'media.content.publish',
          ),
          1 => 
          array (
            0 => 'content',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2503 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'mobile.equipment',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2537 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'mobile.event-details',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2563 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'mobile.event-register',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2600 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'mobile.program-register',
          ),
          1 => 
          array (
            0 => 'program',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2639 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'transactions.show',
          ),
          1 => 
          array (
            0 => 'transaction',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2656 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'transactions.edit',
          ),
          1 => 
          array (
            0 => 'transaction',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2672 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'transactions.deleteReceipt',
          ),
          1 => 
          array (
            0 => 'transaction',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2682 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'transactions.update',
          ),
          1 => 
          array (
            0 => 'transaction',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2699 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'transactions.pending',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2730 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'transactions.approve',
          ),
          1 => 
          array (
            0 => 'transaction',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2745 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'transactions.reject',
          ),
          1 => 
          array (
            0 => 'transaction',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2755 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'transactions.destroy',
          ),
          1 => 
          array (
            0 => 'transaction',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2787 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'visitors.show',
          ),
          1 => 
          array (
            0 => 'visitor',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2804 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'visitors.edit',
          ),
          1 => 
          array (
            0 => 'visitor',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2826 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'visitors.recordVisit',
          ),
          1 => 
          array (
            0 => 'visitor',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2845 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'visitors.convert.form',
          ),
          1 => 
          array (
            0 => 'visitor',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'visitors.convert',
          ),
          1 => 
          array (
            0 => 'visitor',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2869 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'visitors.markInactive',
          ),
          1 => 
          array (
            0 => 'visitor',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2879 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'visitors.update',
          ),
          1 => 
          array (
            0 => 'visitor',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'visitors.destroy',
          ),
          1 => 
          array (
            0 => 'visitor',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2908 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'sms.show',
          ),
          1 => 
          array (
            0 => 'broadcast',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2925 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'sms.send',
          ),
          1 => 
          array (
            0 => 'broadcast',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2939 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'sms.status',
          ),
          1 => 
          array (
            0 => 'broadcast',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2970 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'shepherds.show',
          ),
          1 => 
          array (
            0 => 'shepherd',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2987 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'shepherds.edit',
          ),
          1 => 
          array (
            0 => 'shepherd',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3012 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'shepherds.manage-flock',
          ),
          1 => 
          array (
            0 => 'shepherd',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3031 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'shepherds.meetings',
          ),
          1 => 
          array (
            0 => 'shepherd',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'shepherds.store-meeting',
          ),
          1 => 
          array (
            0 => 'shepherd',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3056 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'shepherds.assign-member',
          ),
          1 => 
          array (
            0 => 'shepherd',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3081 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'shepherds.unassign-member',
          ),
          1 => 
          array (
            0 => 'shepherd',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3104 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'shepherds.visitations',
          ),
          1 => 
          array (
            0 => 'shepherd',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'shepherds.store-visitation',
          ),
          1 => 
          array (
            0 => 'shepherd',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3135 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'shepherds.create-visitation',
          ),
          1 => 
          array (
            0 => 'shepherd',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3151 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'shepherds.create-meeting',
          ),
          1 => 
          array (
            0 => 'shepherd',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3168 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'shepherds.reports',
          ),
          1 => 
          array (
            0 => 'shepherd',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3178 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'shepherds.update',
          ),
          1 => 
          array (
            0 => 'shepherd',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'shepherds.destroy',
          ),
          1 => 
          array (
            0 => 'shepherd',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3219 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'service-units.show',
          ),
          1 => 
          array (
            0 => 'serviceUnit',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3236 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'service-units.edit',
          ),
          1 => 
          array (
            0 => 'serviceUnit',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3260 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'service-units.manage-members',
          ),
          1 => 
          array (
            0 => 'serviceUnit',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3280 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'service-units.add-member',
          ),
          1 => 
          array (
            0 => 'serviceUnit',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3303 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'service-units.remove-member',
          ),
          1 => 
          array (
            0 => 'serviceUnit',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3328 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'service-units.duty-rosters',
          ),
          1 => 
          array (
            0 => 'serviceUnit',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'service-units.store-duty-roster',
          ),
          1 => 
          array (
            0 => 'serviceUnit',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3358 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'service-units.create-duty-roster',
          ),
          1 => 
          array (
            0 => 'serviceUnit',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3368 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'service-units.update',
          ),
          1 => 
          array (
            0 => 'serviceUnit',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'service-units.destroy',
          ),
          1 => 
          array (
            0 => 'serviceUnit',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3394 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'services.show',
          ),
          1 => 
          array (
            0 => 'service',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3411 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'services.edit',
          ),
          1 => 
          array (
            0 => 'service',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3427 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'services.publish',
          ),
          1 => 
          array (
            0 => 'service',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3441 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'services.start',
          ),
          1 => 
          array (
            0 => 'service',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3461 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'services.complete',
          ),
          1 => 
          array (
            0 => 'service',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3475 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'services.cancel',
          ),
          1 => 
          array (
            0 => 'service',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3494 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'services.duplicate',
          ),
          1 => 
          array (
            0 => 'service',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3519 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'services.worship-plan',
          ),
          1 => 
          array (
            0 => 'service',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'services.store-worship-item',
          ),
          1 => 
          array (
            0 => 'service',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3530 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'services.update',
          ),
          1 => 
          array (
            0 => 'service',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'services.destroy',
          ),
          1 => 
          array (
            0 => 'service',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3565 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'services.update-worship-item',
          ),
          1 => 
          array (
            0 => 'item',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'services.destroy-worship-item',
          ),
          1 => 
          array (
            0 => 'item',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3608 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'services.reorder-worship-plan',
          ),
          1 => 
          array (
            0 => 'service',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3630 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'services.volunteers',
          ),
          1 => 
          array (
            0 => 'service',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'services.assign-volunteer',
          ),
          1 => 
          array (
            0 => 'service',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3663 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'services.update-volunteer',
          ),
          1 => 
          array (
            0 => 'volunteer',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'services.remove-volunteer',
          ),
          1 => 
          array (
            0 => 'volunteer',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3680 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'services.confirm-volunteer',
          ),
          1 => 
          array (
            0 => 'volunteer',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3735 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'settings.edit-email-template',
          ),
          1 => 
          array (
            0 => 'template',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3744 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'settings.update-email-template',
          ),
          1 => 
          array (
            0 => 'template',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3782 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'settings.download-backup',
          ),
          1 => 
          array (
            0 => 'backup',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3791 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'settings.delete-backup',
          ),
          1 => 
          array (
            0 => 'backup',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3826 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'equipment.show',
          ),
          1 => 
          array (
            0 => 'equipment',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3843 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'equipment.edit',
          ),
          1 => 
          array (
            0 => 'equipment',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3872 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'equipment.maintenance.form',
          ),
          1 => 
          array (
            0 => 'equipment',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3881 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'equipment.maintenance.record',
          ),
          1 => 
          array (
            0 => 'equipment',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3912 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'equipment.maintenance.schedule',
          ),
          1 => 
          array (
            0 => 'equipment',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3922 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'equipment.update',
          ),
          1 => 
          array (
            0 => 'equipment',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'equipment.destroy',
          ),
          1 => 
          array (
            0 => 'equipment',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3963 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'service-units.publish-duty-roster',
          ),
          1 => 
          array (
            0 => 'dutyRoster',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4002 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'programs.show',
          ),
          1 => 
          array (
            0 => 'program',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4019 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'programs.edit',
          ),
          1 => 
          array (
            0 => 'program',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4035 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'programs.publish',
          ),
          1 => 
          array (
            0 => 'program',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4049 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'programs.start',
          ),
          1 => 
          array (
            0 => 'program',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4069 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'programs.complete',
          ),
          1 => 
          array (
            0 => 'program',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4083 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'programs.cancel',
          ),
          1 => 
          array (
            0 => 'program',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4106 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'programs.manage-registrations',
          ),
          1 => 
          array (
            0 => 'program',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4116 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'programs.update',
          ),
          1 => 
          array (
            0 => 'program',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'programs.destroy',
          ),
          1 => 
          array (
            0 => 'program',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4158 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'programs.check-in',
          ),
          1 => 
          array (
            0 => 'registration',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4187 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'programs.manage-sessions',
          ),
          1 => 
          array (
            0 => 'program',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'programs.store-session',
          ),
          1 => 
          array (
            0 => 'program',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4217 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'programs.update-session',
          ),
          1 => 
          array (
            0 => 'session',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'programs.destroy-session',
          ),
          1 => 
          array (
            0 => 'session',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4248 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'programs.analytics',
          ),
          1 => 
          array (
            0 => 'program',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4268 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'programs.registration-form',
          ),
          1 => 
          array (
            0 => 'program',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'programs.register',
          ),
          1 => 
          array (
            0 => 'program',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4309 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'programs.registration-success',
          ),
          1 => 
          array (
            0 => 'registration',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4348 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'prayer.assign',
          ),
          1 => 
          array (
            0 => 'prayerRequest',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4367 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'prayer.add-update',
          ),
          1 => 
          array (
            0 => 'prayerRequest',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4391 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'prayer.mark-answered',
          ),
          1 => 
          array (
            0 => 'prayerRequest',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4429 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'prayer.approve-testimony',
          ),
          1 => 
          array (
            0 => 'testimony',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4449 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'prayer.show',
          ),
          1 => 
          array (
            0 => 'prayerRequest',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4463 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'prayer.edit',
          ),
          1 => 
          array (
            0 => 'prayerRequest',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4472 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'prayer.update',
          ),
          1 => 
          array (
            0 => 'prayerRequest',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'prayer.destroy',
          ),
          1 => 
          array (
            0 => 'prayerRequest',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4486 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'prayer.wall',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4510 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'prayer.my-requests',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4530 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'prayer.my-assignments',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4582 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'partnerships.agreements.activate',
          ),
          1 => 
          array (
            0 => 'agreement',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4635 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'birthdays.recognize-milestone',
          ),
          1 => 
          array (
            0 => 'milestone',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4674 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'birthdays.mark-announcement-displayed',
          ),
          1 => 
          array (
            0 => 'announcement',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4700 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'birthdays.update-settings',
          ),
          1 => 
          array (
            0 => 'eventType',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4760 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'childrens-ministry.children.show',
          ),
          1 => 
          array (
            0 => 'child',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4784 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'childrens-ministry.checkout.process',
          ),
          1 => 
          array (
            0 => 'checkin',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4815 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'childrens-ministry.curriculum.show',
          ),
          1 => 
          array (
            0 => 'lesson',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4832 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'childrens-ministry.curriculum.edit',
          ),
          1 => 
          array (
            0 => 'lesson',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4848 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'childrens-ministry.curriculum.publish',
          ),
          1 => 
          array (
            0 => 'lesson',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4858 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'childrens-ministry.curriculum.update',
          ),
          1 => 
          array (
            0 => 'lesson',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'childrens-ministry.curriculum.delete',
          ),
          1 => 
          array (
            0 => 'lesson',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4887 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'childrens-ministry.events.show',
          ),
          1 => 
          array (
            0 => 'event',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'childrens-ministry.events.update',
          ),
          1 => 
          array (
            0 => 'event',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4908 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'childrens-ministry.events.register',
          ),
          1 => 
          array (
            0 => 'event',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4924 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'childrens-ministry.events.publish',
          ),
          1 => 
          array (
            0 => 'event',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4938 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'childrens-ministry.events.start',
          ),
          1 => 
          array (
            0 => 'event',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4955 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'childrens-ministry.events.complete',
          ),
          1 => 
          array (
            0 => 'event',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5007 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'counselling.counsellors.show',
          ),
          1 => 
          array (
            0 => 'counsellor',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'counselling.counsellors.update',
          ),
          1 => 
          array (
            0 => 'counsellor',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5028 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'counselling.counsellors.activate',
          ),
          1 => 
          array (
            0 => 'counsellor',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5047 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'counselling.counsellors.deactivate',
          ),
          1 => 
          array (
            0 => 'counsellor',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5074 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'counselling.cases.show',
          ),
          1 => 
          array (
            0 => 'case',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'counselling.cases.update',
          ),
          1 => 
          array (
            0 => 'case',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5095 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'counselling.cases.activate',
          ),
          1 => 
          array (
            0 => 'case',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5108 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'counselling.cases.hold',
          ),
          1 => 
          array (
            0 => 'case',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5122 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'counselling.cases.close',
          ),
          1 => 
          array (
            0 => 'case',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5154 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'counselling.sessions.show',
          ),
          1 => 
          array (
            0 => 'session',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'counselling.sessions.update',
          ),
          1 => 
          array (
            0 => 'session',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5180 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'counselling.sessions.confirm',
          ),
          1 => 
          array (
            0 => 'session',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5195 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'counselling.sessions.complete',
          ),
          1 => 
          array (
            0 => 'session',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5210 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'counselling.sessions.cancel',
          ),
          1 => 
          array (
            0 => 'session',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5225 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'counselling.sessions.start',
          ),
          1 => 
          array (
            0 => 'session',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5244 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'counselling.sessions.reschedule',
          ),
          1 => 
          array (
            0 => 'session',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5276 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'counselling.resources.show',
          ),
          1 => 
          array (
            0 => 'resource',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'counselling.resources.update',
          ),
          1 => 
          array (
            0 => 'resource',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5294 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'counselling.resources.download',
          ),
          1 => 
          array (
            0 => 'resource',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5335 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'welfare.cases.show',
          ),
          1 => 
          array (
            0 => 'case',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'welfare.cases.update',
          ),
          1 => 
          array (
            0 => 'case',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5361 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'welfare.cases.under-review',
          ),
          1 => 
          array (
            0 => 'case',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5376 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'welfare.cases.verify',
          ),
          1 => 
          array (
            0 => 'case',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5408 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'welfare.cases.reject-verification',
          ),
          1 => 
          array (
            0 => 'case',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5417 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'welfare.cases.reject',
          ),
          1 => 
          array (
            0 => 'case',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5434 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'welfare.cases.approve',
          ),
          1 => 
          array (
            0 => 'case',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5448 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'welfare.cases.close',
          ),
          1 => 
          array (
            0 => 'case',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5479 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'welfare.programs.show',
          ),
          1 => 
          array (
            0 => 'program',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'welfare.programs.update',
          ),
          1 => 
          array (
            0 => 'program',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5500 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'welfare.programs.activate',
          ),
          1 => 
          array (
            0 => 'program',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5514 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'welfare.programs.pause',
          ),
          1 => 
          array (
            0 => 'program',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5531 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'welfare.programs.complete',
          ),
          1 => 
          array (
            0 => 'program',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5578 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'qr-codes.equipment',
          ),
          1 => 
          array (
            0 => 'equipment',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5603 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'qr-codes.program',
          ),
          1 => 
          array (
            0 => 'program',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5635 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'qr-management.show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5654 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'qr-management.revoke',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5669 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'qr-management.extend',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5683 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'qr-management.image',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5700 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'qr-management.download',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => NULL,
          1 => NULL,
          2 => NULL,
          3 => NULL,
          4 => false,
          5 => false,
          6 => 0,
        ),
      ),
    ),
    4 => NULL,
  ),
  'attributes' => 
  array (
    'sanctum.csrf-cookie' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'sanctum/csrf-cookie',
      'action' => 
      array (
        'uses' => 'Laravel\\Sanctum\\Http\\Controllers\\CsrfCookieController@show',
        'controller' => 'Laravel\\Sanctum\\Http\\Controllers\\CsrfCookieController@show',
        'namespace' => NULL,
        'prefix' => 'sanctum',
        'where' => 
        array (
        ),
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => 'sanctum.csrf-cookie',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ignition.healthCheck' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '_ignition/health-check',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'Spatie\\LaravelIgnition\\Http\\Middleware\\RunnableSolutionsEnabled',
        ),
        'uses' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\HealthCheckController@__invoke',
        'controller' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\HealthCheckController',
        'as' => 'ignition.healthCheck',
        'namespace' => NULL,
        'prefix' => '_ignition',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ignition.executeSolution' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => '_ignition/execute-solution',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'Spatie\\LaravelIgnition\\Http\\Middleware\\RunnableSolutionsEnabled',
        ),
        'uses' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\ExecuteSolutionController@__invoke',
        'controller' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\ExecuteSolutionController',
        'as' => 'ignition.executeSolution',
        'namespace' => NULL,
        'prefix' => '_ignition',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ignition.updateConfig' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => '_ignition/update-config',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'Spatie\\LaravelIgnition\\Http\\Middleware\\RunnableSolutionsEnabled',
        ),
        'uses' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\UpdateConfigController@__invoke',
        'controller' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\UpdateConfigController',
        'as' => 'ignition.updateConfig',
        'namespace' => NULL,
        'prefix' => '_ignition',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::VicvQSe5A1PtGL1G' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'throttle:5,1',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\AuthController@apiLogin',
        'controller' => 'App\\Http\\Controllers\\Auth\\AuthController@apiLogin',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::VicvQSe5A1PtGL1G',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::8Sk4VnU2GjWGuglg' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/register',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'throttle:3,1',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\AuthController@register',
        'controller' => 'App\\Http\\Controllers\\Auth\\AuthController@register',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::8Sk4VnU2GjWGuglg',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::xo1NI3kY3kQRKI9Y' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/forgot-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'throttle:3,1',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\AuthController@sendResetLink',
        'controller' => 'App\\Http\\Controllers\\Auth\\AuthController@sendResetLink',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::xo1NI3kY3kQRKI9Y',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::MfS2QQLcsu6BT3IF' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/reset-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'throttle:3,1',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\AuthController@resetPassword',
        'controller' => 'App\\Http\\Controllers\\Auth\\AuthController@resetPassword',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::MfS2QQLcsu6BT3IF',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::26bZrjyFdSfVCjMP' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/user',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:101:"function (\\Illuminate\\Http\\Request $request) {
        return $request->user()->load(\'member\');
    }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000009560000000000000000";}}',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::26bZrjyFdSfVCjMP',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::XYvASMBvRdZZVZcJ' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/logout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\AuthController@logout',
        'controller' => 'App\\Http\\Controllers\\Auth\\AuthController@logout',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::XYvASMBvRdZZVZcJ',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::neogY3HtZzLVqQOb' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/dashboard/stats',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\DashboardController@stats',
        'controller' => 'App\\Http\\Controllers\\DashboardController@stats',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::neogY3HtZzLVqQOb',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::hq4UixyGgxBMTZDr' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/dashboard/charts',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\DashboardController@charts',
        'controller' => 'App\\Http\\Controllers\\DashboardController@charts',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::hq4UixyGgxBMTZDr',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::CkBSoDITdBKgHC2n' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/dashboard/recent-activity',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\DashboardController@recentActivity',
        'controller' => 'App\\Http\\Controllers\\DashboardController@recentActivity',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::CkBSoDITdBKgHC2n',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::XLBJ504xtIiJqEYn' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/notifications',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\NotificationController@index',
        'controller' => 'App\\Http\\Controllers\\NotificationController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1/notifications',
        'where' => 
        array (
        ),
        'as' => 'generated::XLBJ504xtIiJqEYn',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::YC6xSv12a5Io79nm' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/notifications/unread',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\NotificationController@unread',
        'controller' => 'App\\Http\\Controllers\\NotificationController@unread',
        'namespace' => NULL,
        'prefix' => 'api/v1/notifications',
        'where' => 
        array (
        ),
        'as' => 'generated::YC6xSv12a5Io79nm',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::qCiyJ1C0REjsJ0Pp' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/notifications/unread-count',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\NotificationController@unreadCount',
        'controller' => 'App\\Http\\Controllers\\NotificationController@unreadCount',
        'namespace' => NULL,
        'prefix' => 'api/v1/notifications',
        'where' => 
        array (
        ),
        'as' => 'generated::qCiyJ1C0REjsJ0Pp',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::pZBu1je5nxyYclln' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/notifications/{notification}/mark-as-read',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\NotificationController@markAsRead',
        'controller' => 'App\\Http\\Controllers\\NotificationController@markAsRead',
        'namespace' => NULL,
        'prefix' => 'api/v1/notifications',
        'where' => 
        array (
        ),
        'as' => 'generated::pZBu1je5nxyYclln',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::p95LUfdONzjQS2sY' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/notifications/mark-all-read',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\NotificationController@markAllAsRead',
        'controller' => 'App\\Http\\Controllers\\NotificationController@markAllAsRead',
        'namespace' => NULL,
        'prefix' => 'api/v1/notifications',
        'where' => 
        array (
        ),
        'as' => 'generated::p95LUfdONzjQS2sY',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::m9ie3JyANv78CL0R' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/v1/notifications/{notification}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\NotificationController@destroy',
        'controller' => 'App\\Http\\Controllers\\NotificationController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/v1/notifications',
        'where' => 
        array (
        ),
        'as' => 'generated::m9ie3JyANv78CL0R',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::qoahZ0kkJ6gFsMTr' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/notifications/preferences',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\NotificationController@preferences',
        'controller' => 'App\\Http\\Controllers\\NotificationController@preferences',
        'namespace' => NULL,
        'prefix' => 'api/v1/notifications',
        'where' => 
        array (
        ),
        'as' => 'generated::qoahZ0kkJ6gFsMTr',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::LJhQIZGPj731O9pJ' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/notifications/preferences',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\NotificationController@updatePreferences',
        'controller' => 'App\\Http\\Controllers\\NotificationController@updatePreferences',
        'namespace' => NULL,
        'prefix' => 'api/v1/notifications',
        'where' => 
        array (
        ),
        'as' => 'generated::LJhQIZGPj731O9pJ',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::7fwRkeN9PgNcya1t' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/my/profile',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\MemberController@getMyProfile',
        'controller' => 'App\\Http\\Controllers\\MemberController@getMyProfile',
        'namespace' => NULL,
        'prefix' => 'api/v1/my',
        'where' => 
        array (
        ),
        'as' => 'generated::7fwRkeN9PgNcya1t',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::YA9DESLcNjnrAcQ8' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/my/profile',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\MemberController@updateMyProfile',
        'controller' => 'App\\Http\\Controllers\\MemberController@updateMyProfile',
        'namespace' => NULL,
        'prefix' => 'api/v1/my',
        'where' => 
        array (
        ),
        'as' => 'generated::YA9DESLcNjnrAcQ8',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::FHd5rtS1CGyaTQ1U' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/my/attendance',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\MemberController@getMyAttendance',
        'controller' => 'App\\Http\\Controllers\\MemberController@getMyAttendance',
        'namespace' => NULL,
        'prefix' => 'api/v1/my',
        'where' => 
        array (
        ),
        'as' => 'generated::FHd5rtS1CGyaTQ1U',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::4ln8xV5f9Btmss0w' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/my/contributions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\MemberController@getMyContributions',
        'controller' => 'App\\Http\\Controllers\\MemberController@getMyContributions',
        'namespace' => NULL,
        'prefix' => 'api/v1/my',
        'where' => 
        array (
        ),
        'as' => 'generated::4ln8xV5f9Btmss0w',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::sb5BSkNMtstN5LbE' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/my/programs',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\MemberController@getMyPrograms',
        'controller' => 'App\\Http\\Controllers\\MemberController@getMyPrograms',
        'namespace' => NULL,
        'prefix' => 'api/v1/my',
        'where' => 
        array (
        ),
        'as' => 'generated::sb5BSkNMtstN5LbE',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::G1H8VWS1wSXKm9a3' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/my/ministry',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\MemberController@getMyMinistry',
        'controller' => 'App\\Http\\Controllers\\MemberController@getMyMinistry',
        'namespace' => NULL,
        'prefix' => 'api/v1/my',
        'where' => 
        array (
        ),
        'as' => 'generated::G1H8VWS1wSXKm9a3',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Bq6kXYBSna0Hrfq5' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/my/shepherd',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\MemberController@getMyShepherd',
        'controller' => 'App\\Http\\Controllers\\MemberController@getMyShepherd',
        'namespace' => NULL,
        'prefix' => 'api/v1/my',
        'where' => 
        array (
        ),
        'as' => 'generated::Bq6kXYBSna0Hrfq5',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Ygin5HrG2YF61A8M' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/my/family',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\MemberController@getMyFamily',
        'controller' => 'App\\Http\\Controllers\\MemberController@getMyFamily',
        'namespace' => NULL,
        'prefix' => 'api/v1/my',
        'where' => 
        array (
        ),
        'as' => 'generated::Ygin5HrG2YF61A8M',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Bw4tE8zAjfzlBvVr' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/my/documents',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\MemberController@getMyDocuments',
        'controller' => 'App\\Http\\Controllers\\MemberController@getMyDocuments',
        'namespace' => NULL,
        'prefix' => 'api/v1/my',
        'where' => 
        array (
        ),
        'as' => 'generated::Bw4tE8zAjfzlBvVr',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.member.documents.download' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/my/documents/{documentId}/download',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\MemberController@downloadDocument',
        'controller' => 'App\\Http\\Controllers\\MemberController@downloadDocument',
        'namespace' => NULL,
        'prefix' => 'api/v1/my',
        'where' => 
        array (
        ),
        'as' => 'api.member.documents.download',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::WV7ofwoyZw9es8Jf' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/my/upcoming-events',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\MemberController@getMyUpcomingEvents',
        'controller' => 'App\\Http\\Controllers\\MemberController@getMyUpcomingEvents',
        'namespace' => NULL,
        'prefix' => 'api/v1/my',
        'where' => 
        array (
        ),
        'as' => 'generated::WV7ofwoyZw9es8Jf',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::WqRhZcGIy4Zeyj9x' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/members',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\MemberController@index',
        'controller' => 'App\\Http\\Controllers\\MemberController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1/members',
        'where' => 
        array (
        ),
        'as' => 'generated::WqRhZcGIy4Zeyj9x',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::fdUQ5QSWfAx86H3l' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/members',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\MemberController@store',
        'controller' => 'App\\Http\\Controllers\\MemberController@store',
        'namespace' => NULL,
        'prefix' => 'api/v1/members',
        'where' => 
        array (
        ),
        'as' => 'generated::fdUQ5QSWfAx86H3l',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::SJwNCEzcV0yDNQga' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/members/search',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\MemberController@search',
        'controller' => 'App\\Http\\Controllers\\MemberController@search',
        'namespace' => NULL,
        'prefix' => 'api/v1/members',
        'where' => 
        array (
        ),
        'as' => 'generated::SJwNCEzcV0yDNQga',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::srkZZihAgwaGTZTp' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/members/statistics',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\MemberController@statistics',
        'controller' => 'App\\Http\\Controllers\\MemberController@statistics',
        'namespace' => NULL,
        'prefix' => 'api/v1/members',
        'where' => 
        array (
        ),
        'as' => 'generated::srkZZihAgwaGTZTp',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::P568hxxw0Bv4QH1N' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/members/export',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\MemberController@export',
        'controller' => 'App\\Http\\Controllers\\MemberController@export',
        'namespace' => NULL,
        'prefix' => 'api/v1/members',
        'where' => 
        array (
        ),
        'as' => 'generated::P568hxxw0Bv4QH1N',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::th4nBobiynYXjpm5' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/members/{member}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\MemberController@show',
        'controller' => 'App\\Http\\Controllers\\MemberController@show',
        'namespace' => NULL,
        'prefix' => 'api/v1/members',
        'where' => 
        array (
        ),
        'as' => 'generated::th4nBobiynYXjpm5',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::jRqEe82Sh4hxCTUr' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/members/{member}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\MemberController@update',
        'controller' => 'App\\Http\\Controllers\\MemberController@update',
        'namespace' => NULL,
        'prefix' => 'api/v1/members',
        'where' => 
        array (
        ),
        'as' => 'generated::jRqEe82Sh4hxCTUr',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::eWYSyEvFEGMiWtkr' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/v1/members/{member}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\MemberController@destroy',
        'controller' => 'App\\Http\\Controllers\\MemberController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/v1/members',
        'where' => 
        array (
        ),
        'as' => 'generated::eWYSyEvFEGMiWtkr',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::RAf82BOUZunLzX6h' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/members/{member}/photo',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\MemberController@uploadPhoto',
        'controller' => 'App\\Http\\Controllers\\MemberController@uploadPhoto',
        'namespace' => NULL,
        'prefix' => 'api/v1/members',
        'where' => 
        array (
        ),
        'as' => 'generated::RAf82BOUZunLzX6h',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ZF3Cs1ABUtai7qgK' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/v1/members/{member}/photo',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\MemberController@deletePhoto',
        'controller' => 'App\\Http\\Controllers\\MemberController@deletePhoto',
        'namespace' => NULL,
        'prefix' => 'api/v1/members',
        'where' => 
        array (
        ),
        'as' => 'generated::ZF3Cs1ABUtai7qgK',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::tEvb4GX6WCj1App5' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/members/bulk-action',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\MemberController@bulkAction',
        'controller' => 'App\\Http\\Controllers\\MemberController@bulkAction',
        'namespace' => NULL,
        'prefix' => 'api/v1/members',
        'where' => 
        array (
        ),
        'as' => 'generated::tEvb4GX6WCj1App5',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::KzQRB3IWu7E3YyGp' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/attendance',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@index',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1/attendance',
        'where' => 
        array (
        ),
        'as' => 'generated::KzQRB3IWu7E3YyGp',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::2uY1WQH4iqcBssRz' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/attendance',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@store',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@store',
        'namespace' => NULL,
        'prefix' => 'api/v1/attendance',
        'where' => 
        array (
        ),
        'as' => 'generated::2uY1WQH4iqcBssRz',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::TWwmCAKsL3RsQkJQ' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/attendance/bulk',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@bulkStore',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@bulkStore',
        'namespace' => NULL,
        'prefix' => 'api/v1/attendance',
        'where' => 
        array (
        ),
        'as' => 'generated::TWwmCAKsL3RsQkJQ',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ldS7HpLlb04qkmQS' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/attendance/reports',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@reports',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@reports',
        'namespace' => NULL,
        'prefix' => 'api/v1/attendance',
        'where' => 
        array (
        ),
        'as' => 'generated::ldS7HpLlb04qkmQS',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::FcZEzVQoBtzQJjZw' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/attendance/leaderboard',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@leaderboard',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@leaderboard',
        'namespace' => NULL,
        'prefix' => 'api/v1/attendance',
        'where' => 
        array (
        ),
        'as' => 'generated::FcZEzVQoBtzQJjZw',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::5FcJgMJ8jFEZ6Fqc' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/attendance/export',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@export',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@export',
        'namespace' => NULL,
        'prefix' => 'api/v1/attendance',
        'where' => 
        array (
        ),
        'as' => 'generated::5FcJgMJ8jFEZ6Fqc',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::kLPXY7QHmXceiXaz' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/attendance/{attendance}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@show',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@show',
        'namespace' => NULL,
        'prefix' => 'api/v1/attendance',
        'where' => 
        array (
        ),
        'as' => 'generated::kLPXY7QHmXceiXaz',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::2pwnGD66lfHPy3Wb' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/attendance/{attendance}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@update',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@update',
        'namespace' => NULL,
        'prefix' => 'api/v1/attendance',
        'where' => 
        array (
        ),
        'as' => 'generated::2pwnGD66lfHPy3Wb',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::TZK32n0mumOxTnHh' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/v1/attendance/{attendance}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@destroy',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/v1/attendance',
        'where' => 
        array (
        ),
        'as' => 'generated::TZK32n0mumOxTnHh',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::9Qa0bYgdoTYuLIhT' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/transactions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\TransactionController@index',
        'controller' => 'App\\Http\\Controllers\\TransactionController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1/transactions',
        'where' => 
        array (
        ),
        'as' => 'generated::9Qa0bYgdoTYuLIhT',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::9jLVhdqs33aMOBRD' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/transactions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\TransactionController@store',
        'controller' => 'App\\Http\\Controllers\\TransactionController@store',
        'namespace' => NULL,
        'prefix' => 'api/v1/transactions',
        'where' => 
        array (
        ),
        'as' => 'generated::9jLVhdqs33aMOBRD',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::wk5hwT2GszVes103' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/transactions/reports',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\TransactionController@reports',
        'controller' => 'App\\Http\\Controllers\\TransactionController@reports',
        'namespace' => NULL,
        'prefix' => 'api/v1/transactions',
        'where' => 
        array (
        ),
        'as' => 'generated::wk5hwT2GszVes103',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::itQ8GckaVcVbcF9V' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/transactions/export',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\TransactionController@export',
        'controller' => 'App\\Http\\Controllers\\TransactionController@export',
        'namespace' => NULL,
        'prefix' => 'api/v1/transactions',
        'where' => 
        array (
        ),
        'as' => 'generated::itQ8GckaVcVbcF9V',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::e93plLueNC0oCCDA' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/transactions/pending',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
          3 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\TransactionController@pending',
        'controller' => 'App\\Http\\Controllers\\TransactionController@pending',
        'namespace' => NULL,
        'prefix' => 'api/v1/transactions',
        'where' => 
        array (
        ),
        'as' => 'generated::e93plLueNC0oCCDA',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::3XHGExUZ1BL83PCa' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/transactions/{transaction}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\TransactionController@show',
        'controller' => 'App\\Http\\Controllers\\TransactionController@show',
        'namespace' => NULL,
        'prefix' => 'api/v1/transactions',
        'where' => 
        array (
        ),
        'as' => 'generated::3XHGExUZ1BL83PCa',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ssnKuw36K2Znp3w4' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/transactions/{transaction}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\TransactionController@update',
        'controller' => 'App\\Http\\Controllers\\TransactionController@update',
        'namespace' => NULL,
        'prefix' => 'api/v1/transactions',
        'where' => 
        array (
        ),
        'as' => 'generated::ssnKuw36K2Znp3w4',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::S4MU2dfGT7rVwICi' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/transactions/{transaction}/approve',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
          3 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\TransactionController@approve',
        'controller' => 'App\\Http\\Controllers\\TransactionController@approve',
        'namespace' => NULL,
        'prefix' => 'api/v1/transactions',
        'where' => 
        array (
        ),
        'as' => 'generated::S4MU2dfGT7rVwICi',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::JkKPWSph6POYFRad' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/transactions/{transaction}/reject',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
          3 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\TransactionController@reject',
        'controller' => 'App\\Http\\Controllers\\TransactionController@reject',
        'namespace' => NULL,
        'prefix' => 'api/v1/transactions',
        'where' => 
        array (
        ),
        'as' => 'generated::JkKPWSph6POYFRad',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::9r71t9YCdCiJN8nV' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/v1/transactions/{transaction}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
          3 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\TransactionController@destroy',
        'controller' => 'App\\Http\\Controllers\\TransactionController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/v1/transactions',
        'where' => 
        array (
        ),
        'as' => 'generated::9r71t9YCdCiJN8nV',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::KCR7yftnvxNMwt30' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/transactions/analytics/dashboard-summary',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\TransactionController@getDashboardSummary',
        'controller' => 'App\\Http\\Controllers\\TransactionController@getDashboardSummary',
        'namespace' => NULL,
        'prefix' => 'api/v1/transactions',
        'where' => 
        array (
        ),
        'as' => 'generated::KCR7yftnvxNMwt30',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::GqHJlWTPvwt9PBdz' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/transactions/analytics/cash-flow',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\TransactionController@getCashFlow',
        'controller' => 'App\\Http\\Controllers\\TransactionController@getCashFlow',
        'namespace' => NULL,
        'prefix' => 'api/v1/transactions',
        'where' => 
        array (
        ),
        'as' => 'generated::GqHJlWTPvwt9PBdz',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Rfw4Fj4BF84XcCRV' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/transactions/analytics/budget-analysis',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\TransactionController@getBudgetAnalysis',
        'controller' => 'App\\Http\\Controllers\\TransactionController@getBudgetAnalysis',
        'namespace' => NULL,
        'prefix' => 'api/v1/transactions',
        'where' => 
        array (
        ),
        'as' => 'generated::Rfw4Fj4BF84XcCRV',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::phSAxykoyo3L6KvP' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/transactions/analytics/giving-analytics',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\TransactionController@getGivingAnalytics',
        'controller' => 'App\\Http\\Controllers\\TransactionController@getGivingAnalytics',
        'namespace' => NULL,
        'prefix' => 'api/v1/transactions',
        'where' => 
        array (
        ),
        'as' => 'generated::phSAxykoyo3L6KvP',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::DBYWisryzU4hyyg0' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/transactions/analytics/expense-analytics',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\TransactionController@getExpenseAnalytics',
        'controller' => 'App\\Http\\Controllers\\TransactionController@getExpenseAnalytics',
        'namespace' => NULL,
        'prefix' => 'api/v1/transactions',
        'where' => 
        array (
        ),
        'as' => 'generated::DBYWisryzU4hyyg0',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::nubM8TCvh5xcNEGL' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/transactions/analytics/forecasting',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\TransactionController@getForecasting',
        'controller' => 'App\\Http\\Controllers\\TransactionController@getForecasting',
        'namespace' => NULL,
        'prefix' => 'api/v1/transactions',
        'where' => 
        array (
        ),
        'as' => 'generated::nubM8TCvh5xcNEGL',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::1nXq1b6wYasoMm5p' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/visitors',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\VisitorController@index',
        'controller' => 'App\\Http\\Controllers\\VisitorController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1/visitors',
        'where' => 
        array (
        ),
        'as' => 'generated::1nXq1b6wYasoMm5p',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::XKLyQKnkDCEtu9PW' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/visitors',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\VisitorController@store',
        'controller' => 'App\\Http\\Controllers\\VisitorController@store',
        'namespace' => NULL,
        'prefix' => 'api/v1/visitors',
        'where' => 
        array (
        ),
        'as' => 'generated::XKLyQKnkDCEtu9PW',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::znudFgU4q6rzNFgF' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/visitors/eligible',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\VisitorController@eligible',
        'controller' => 'App\\Http\\Controllers\\VisitorController@eligible',
        'namespace' => NULL,
        'prefix' => 'api/v1/visitors',
        'where' => 
        array (
        ),
        'as' => 'generated::znudFgU4q6rzNFgF',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::mTGaZbnI72QTTzDr' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/visitors/follow-up',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\VisitorController@followUp',
        'controller' => 'App\\Http\\Controllers\\VisitorController@followUp',
        'namespace' => NULL,
        'prefix' => 'api/v1/visitors',
        'where' => 
        array (
        ),
        'as' => 'generated::mTGaZbnI72QTTzDr',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::3WSEqTNc4ItNTYQU' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/visitors/reports',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\VisitorController@reports',
        'controller' => 'App\\Http\\Controllers\\VisitorController@reports',
        'namespace' => NULL,
        'prefix' => 'api/v1/visitors',
        'where' => 
        array (
        ),
        'as' => 'generated::3WSEqTNc4ItNTYQU',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::UNOSOuPNigdtPpHE' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/visitors/{visitor}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\VisitorController@show',
        'controller' => 'App\\Http\\Controllers\\VisitorController@show',
        'namespace' => NULL,
        'prefix' => 'api/v1/visitors',
        'where' => 
        array (
        ),
        'as' => 'generated::UNOSOuPNigdtPpHE',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::OVLH82fMq3IkjzSV' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/visitors/{visitor}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\VisitorController@update',
        'controller' => 'App\\Http\\Controllers\\VisitorController@update',
        'namespace' => NULL,
        'prefix' => 'api/v1/visitors',
        'where' => 
        array (
        ),
        'as' => 'generated::OVLH82fMq3IkjzSV',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::W9bHhGupeX8MFLMZ' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/v1/visitors/{visitor}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\VisitorController@destroy',
        'controller' => 'App\\Http\\Controllers\\VisitorController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/v1/visitors',
        'where' => 
        array (
        ),
        'as' => 'generated::W9bHhGupeX8MFLMZ',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ptKSLktmIJVJz5zh' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/visitors/{visitor}/record-visit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\VisitorController@recordVisit',
        'controller' => 'App\\Http\\Controllers\\VisitorController@recordVisit',
        'namespace' => NULL,
        'prefix' => 'api/v1/visitors',
        'where' => 
        array (
        ),
        'as' => 'generated::ptKSLktmIJVJz5zh',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::uo8XOiwR0RZ5TEWe' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/visitors/{visitor}/convert',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\VisitorController@convert',
        'controller' => 'App\\Http\\Controllers\\VisitorController@convert',
        'namespace' => NULL,
        'prefix' => 'api/v1/visitors',
        'where' => 
        array (
        ),
        'as' => 'generated::uo8XOiwR0RZ5TEWe',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::0o4gbUzKFGrF2MFh' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/sms',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\SmsBroadcastController@index',
        'controller' => 'App\\Http\\Controllers\\SmsBroadcastController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1/sms',
        'where' => 
        array (
        ),
        'as' => 'generated::0o4gbUzKFGrF2MFh',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::OlTHSqmGD5MWD1aF' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/sms',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\SmsBroadcastController@store',
        'controller' => 'App\\Http\\Controllers\\SmsBroadcastController@store',
        'namespace' => NULL,
        'prefix' => 'api/v1/sms',
        'where' => 
        array (
        ),
        'as' => 'generated::OlTHSqmGD5MWD1aF',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::XoReF1ksp7pTn5CQ' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/sms/{broadcast}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\SmsBroadcastController@show',
        'controller' => 'App\\Http\\Controllers\\SmsBroadcastController@show',
        'namespace' => NULL,
        'prefix' => 'api/v1/sms',
        'where' => 
        array (
        ),
        'as' => 'generated::XoReF1ksp7pTn5CQ',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::EH7aSQIyiNLZljYJ' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/sms/{broadcast}/send',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\SmsBroadcastController@send',
        'controller' => 'App\\Http\\Controllers\\SmsBroadcastController@send',
        'namespace' => NULL,
        'prefix' => 'api/v1/sms',
        'where' => 
        array (
        ),
        'as' => 'generated::EH7aSQIyiNLZljYJ',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::2SSzpYVZrcR4xst1' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/sms/{broadcast}/status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\SmsBroadcastController@status',
        'controller' => 'App\\Http\\Controllers\\SmsBroadcastController@status',
        'namespace' => NULL,
        'prefix' => 'api/v1/sms',
        'where' => 
        array (
        ),
        'as' => 'generated::2SSzpYVZrcR4xst1',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::eS8E0noqtfourFu3' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/sms/templates/list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\SmsBroadcastController@getTemplates',
        'controller' => 'App\\Http\\Controllers\\SmsBroadcastController@getTemplates',
        'namespace' => NULL,
        'prefix' => 'api/v1/sms',
        'where' => 
        array (
        ),
        'as' => 'generated::eS8E0noqtfourFu3',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::AvZD5FbL6zgRJilU' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/sms/preview',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\SmsBroadcastController@previewMessage',
        'controller' => 'App\\Http\\Controllers\\SmsBroadcastController@previewMessage',
        'namespace' => NULL,
        'prefix' => 'api/v1/sms',
        'where' => 
        array (
        ),
        'as' => 'generated::AvZD5FbL6zgRJilU',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::NLhVMQpyc4cgukE2' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/sms/stats/delivery',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\SmsBroadcastController@deliveryStats',
        'controller' => 'App\\Http\\Controllers\\SmsBroadcastController@deliveryStats',
        'namespace' => NULL,
        'prefix' => 'api/v1/sms',
        'where' => 
        array (
        ),
        'as' => 'generated::NLhVMQpyc4cgukE2',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::sLZsslKA0Kj4zOy3' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/sms/validate/phones',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\SmsBroadcastController@validatePhones',
        'controller' => 'App\\Http\\Controllers\\SmsBroadcastController@validatePhones',
        'namespace' => NULL,
        'prefix' => 'api/v1/sms',
        'where' => 
        array (
        ),
        'as' => 'generated::sLZsslKA0Kj4zOy3',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::nVHAGJJnPhgsLUyq' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/sms/message/info',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\SmsBroadcastController@getMessageInfo',
        'controller' => 'App\\Http\\Controllers\\SmsBroadcastController@getMessageInfo',
        'namespace' => NULL,
        'prefix' => 'api/v1/sms',
        'where' => 
        array (
        ),
        'as' => 'generated::nVHAGJJnPhgsLUyq',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::e1Tn71Z4FjRpVAqH' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/programs',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ProgramController@index',
        'controller' => 'App\\Http\\Controllers\\ProgramController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1/programs',
        'where' => 
        array (
        ),
        'as' => 'generated::e1Tn71Z4FjRpVAqH',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::i7tiH1rNLoXyxJ8e' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/programs',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ProgramController@store',
        'controller' => 'App\\Http\\Controllers\\ProgramController@store',
        'namespace' => NULL,
        'prefix' => 'api/v1/programs',
        'where' => 
        array (
        ),
        'as' => 'generated::i7tiH1rNLoXyxJ8e',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::PYAoJ6vJj85iI5s4' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/programs/{program}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ProgramController@show',
        'controller' => 'App\\Http\\Controllers\\ProgramController@show',
        'namespace' => NULL,
        'prefix' => 'api/v1/programs',
        'where' => 
        array (
        ),
        'as' => 'generated::PYAoJ6vJj85iI5s4',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::JzlOZX34u0ro9w9X' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/programs/{program}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ProgramController@update',
        'controller' => 'App\\Http\\Controllers\\ProgramController@update',
        'namespace' => NULL,
        'prefix' => 'api/v1/programs',
        'where' => 
        array (
        ),
        'as' => 'generated::JzlOZX34u0ro9w9X',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::goaIOxu0dBA7y42T' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/v1/programs/{program}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ProgramController@destroy',
        'controller' => 'App\\Http\\Controllers\\ProgramController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/v1/programs',
        'where' => 
        array (
        ),
        'as' => 'generated::goaIOxu0dBA7y42T',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::NZ9c8KeI3sjFDTnt' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/programs/{program}/publish',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ProgramController@publish',
        'controller' => 'App\\Http\\Controllers\\ProgramController@publish',
        'namespace' => NULL,
        'prefix' => 'api/v1/programs',
        'where' => 
        array (
        ),
        'as' => 'generated::NZ9c8KeI3sjFDTnt',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::5TWQpL43ydrqK6g0' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/programs/{program}/start',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ProgramController@start',
        'controller' => 'App\\Http\\Controllers\\ProgramController@start',
        'namespace' => NULL,
        'prefix' => 'api/v1/programs',
        'where' => 
        array (
        ),
        'as' => 'generated::5TWQpL43ydrqK6g0',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::bRs9vq9Vc8rzWCTO' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/programs/{program}/complete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ProgramController@complete',
        'controller' => 'App\\Http\\Controllers\\ProgramController@complete',
        'namespace' => NULL,
        'prefix' => 'api/v1/programs',
        'where' => 
        array (
        ),
        'as' => 'generated::bRs9vq9Vc8rzWCTO',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::MdabxQEnywoTqDlQ' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/programs/{program}/cancel',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ProgramController@cancel',
        'controller' => 'App\\Http\\Controllers\\ProgramController@cancel',
        'namespace' => NULL,
        'prefix' => 'api/v1/programs',
        'where' => 
        array (
        ),
        'as' => 'generated::MdabxQEnywoTqDlQ',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::htqvgySh79bCJqFG' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/programs/{program}/registrations',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ProgramController@manageRegistrations',
        'controller' => 'App\\Http\\Controllers\\ProgramController@manageRegistrations',
        'namespace' => NULL,
        'prefix' => 'api/v1/programs',
        'where' => 
        array (
        ),
        'as' => 'generated::htqvgySh79bCJqFG',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ZP6Mt3UJF8z3oBjE' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/programs/registrations/{registration}/check-in',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ProgramController@checkIn',
        'controller' => 'App\\Http\\Controllers\\ProgramController@checkIn',
        'namespace' => NULL,
        'prefix' => 'api/v1/programs',
        'where' => 
        array (
        ),
        'as' => 'generated::ZP6Mt3UJF8z3oBjE',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::devlhCiufnKfaXkn' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/programs/{program}/analytics',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ProgramController@analytics',
        'controller' => 'App\\Http\\Controllers\\ProgramController@analytics',
        'namespace' => NULL,
        'prefix' => 'api/v1/programs',
        'where' => 
        array (
        ),
        'as' => 'generated::devlhCiufnKfaXkn',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::uuOsHYxKKR2Hz5Nt' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/programs/{program}/register',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\ProgramController@register',
        'controller' => 'App\\Http\\Controllers\\ProgramController@register',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::uuOsHYxKKR2Hz5Nt',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::VxaKfeUbtZqD3nlP' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/prayer/wall',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\PrayerController@prayerWall',
        'controller' => 'App\\Http\\Controllers\\PrayerController@prayerWall',
        'namespace' => NULL,
        'prefix' => 'api/v1/prayer',
        'where' => 
        array (
        ),
        'as' => 'generated::VxaKfeUbtZqD3nlP',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::K3j64XwyIlOTmKWo' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/prayer/my-requests',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\PrayerController@myRequests',
        'controller' => 'App\\Http\\Controllers\\PrayerController@myRequests',
        'namespace' => NULL,
        'prefix' => 'api/v1/prayer',
        'where' => 
        array (
        ),
        'as' => 'generated::K3j64XwyIlOTmKWo',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::FqpZt1zzJQ1HOfrd' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/prayer',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\PrayerController@store',
        'controller' => 'App\\Http\\Controllers\\PrayerController@store',
        'namespace' => NULL,
        'prefix' => 'api/v1/prayer',
        'where' => 
        array (
        ),
        'as' => 'generated::FqpZt1zzJQ1HOfrd',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::UQF7hu9fMtLQNH8v' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/prayer/{prayerRequest}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\PrayerController@show',
        'controller' => 'App\\Http\\Controllers\\PrayerController@show',
        'namespace' => NULL,
        'prefix' => 'api/v1/prayer',
        'where' => 
        array (
        ),
        'as' => 'generated::UQF7hu9fMtLQNH8v',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::S8K7dOEi2gqfig4p' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/prayer/{prayerRequest}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\PrayerController@update',
        'controller' => 'App\\Http\\Controllers\\PrayerController@update',
        'namespace' => NULL,
        'prefix' => 'api/v1/prayer',
        'where' => 
        array (
        ),
        'as' => 'generated::S8K7dOEi2gqfig4p',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::oI8QD2AXwnFLgtVf' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/v1/prayer/{prayerRequest}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\PrayerController@destroy',
        'controller' => 'App\\Http\\Controllers\\PrayerController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/v1/prayer',
        'where' => 
        array (
        ),
        'as' => 'generated::oI8QD2AXwnFLgtVf',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::aJAHoR9qKA7GIkEA' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/prayer',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\PrayerController@index',
        'controller' => 'App\\Http\\Controllers\\PrayerController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1/prayer',
        'where' => 
        array (
        ),
        'as' => 'generated::aJAHoR9qKA7GIkEA',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::x74zte1I0SFImQ9T' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/prayer/analytics',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\PrayerController@analytics',
        'controller' => 'App\\Http\\Controllers\\PrayerController@analytics',
        'namespace' => NULL,
        'prefix' => 'api/v1/prayer',
        'where' => 
        array (
        ),
        'as' => 'generated::x74zte1I0SFImQ9T',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::cEyTYb9IEfYWSCr6' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/prayer/{prayerRequest}/assign',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\PrayerController@assign',
        'controller' => 'App\\Http\\Controllers\\PrayerController@assign',
        'namespace' => NULL,
        'prefix' => 'api/v1/prayer',
        'where' => 
        array (
        ),
        'as' => 'generated::cEyTYb9IEfYWSCr6',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::uoTRKfnPks5QKl28' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/prayer/{prayerRequest}/add-update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\PrayerController@addUpdate',
        'controller' => 'App\\Http\\Controllers\\PrayerController@addUpdate',
        'namespace' => NULL,
        'prefix' => 'api/v1/prayer',
        'where' => 
        array (
        ),
        'as' => 'generated::uoTRKfnPks5QKl28',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ytQGgviJ3btrimSd' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/prayer/{prayerRequest}/mark-answered',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\PrayerController@markAnswered',
        'controller' => 'App\\Http\\Controllers\\PrayerController@markAnswered',
        'namespace' => NULL,
        'prefix' => 'api/v1/prayer',
        'where' => 
        array (
        ),
        'as' => 'generated::ytQGgviJ3btrimSd',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::l6gCWjARRgP28NVq' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/prayer/testimonies',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\PrayerController@testimonies',
        'controller' => 'App\\Http\\Controllers\\PrayerController@testimonies',
        'namespace' => NULL,
        'prefix' => 'api/v1/prayer',
        'where' => 
        array (
        ),
        'as' => 'generated::l6gCWjARRgP28NVq',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Hb5b9MWxbkYWx2cg' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/birthdays',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\BirthdayController@index',
        'controller' => 'App\\Http\\Controllers\\BirthdayController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1/birthdays',
        'where' => 
        array (
        ),
        'as' => 'generated::Hb5b9MWxbkYWx2cg',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::DP9rMkbyXhs4GIhV' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/birthdays/calendar',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\BirthdayController@calendar',
        'controller' => 'App\\Http\\Controllers\\BirthdayController@calendar',
        'namespace' => NULL,
        'prefix' => 'api/v1/birthdays',
        'where' => 
        array (
        ),
        'as' => 'generated::DP9rMkbyXhs4GIhV',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::UUSoGA7uQIJd0a2d' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/birthdays/history',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\BirthdayController@history',
        'controller' => 'App\\Http\\Controllers\\BirthdayController@history',
        'namespace' => NULL,
        'prefix' => 'api/v1/birthdays',
        'where' => 
        array (
        ),
        'as' => 'generated::UUSoGA7uQIJd0a2d',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ZFtSrjQU10uJiyEa' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/birthdays/milestones',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\BirthdayController@milestones',
        'controller' => 'App\\Http\\Controllers\\BirthdayController@milestones',
        'namespace' => NULL,
        'prefix' => 'api/v1/birthdays',
        'where' => 
        array (
        ),
        'as' => 'generated::ZFtSrjQU10uJiyEa',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::gB4t5xadJ31ogbHs' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/birthdays/milestones/{milestone}/recognize',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\BirthdayController@recognizeMilestone',
        'controller' => 'App\\Http\\Controllers\\BirthdayController@recognizeMilestone',
        'namespace' => NULL,
        'prefix' => 'api/v1/birthdays',
        'where' => 
        array (
        ),
        'as' => 'generated::gB4t5xadJ31ogbHs',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::jTUTGdZ6aeBL0GXQ' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/birthdays/analytics',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\BirthdayController@analytics',
        'controller' => 'App\\Http\\Controllers\\BirthdayController@analytics',
        'namespace' => NULL,
        'prefix' => 'api/v1/birthdays',
        'where' => 
        array (
        ),
        'as' => 'generated::jTUTGdZ6aeBL0GXQ',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::9BH3gLpy7EHuFaE0' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/birthdays/upcoming-celebrations',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\BirthdayController@upcomingCelebrations',
        'controller' => 'App\\Http\\Controllers\\BirthdayController@upcomingCelebrations',
        'namespace' => NULL,
        'prefix' => 'api/v1/birthdays',
        'where' => 
        array (
        ),
        'as' => 'generated::9BH3gLpy7EHuFaE0',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::HOIAPKt9dc9KP7XT' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/birthdays/generate-announcements',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\BirthdayController@generateAnnouncements',
        'controller' => 'App\\Http\\Controllers\\BirthdayController@generateAnnouncements',
        'namespace' => NULL,
        'prefix' => 'api/v1/birthdays',
        'where' => 
        array (
        ),
        'as' => 'generated::HOIAPKt9dc9KP7XT',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::WK6UvkmW6oTBwDCp' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/birthdays/test-workflow',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\BirthdayController@testWorkflow',
        'controller' => 'App\\Http\\Controllers\\BirthdayController@testWorkflow',
        'namespace' => NULL,
        'prefix' => 'api/v1/birthdays',
        'where' => 
        array (
        ),
        'as' => 'generated::WK6UvkmW6oTBwDCp',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::uTgcmwOG27ge07wB' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/birthdays/schedule-preview',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\BirthdayController@schedulePreview',
        'controller' => 'App\\Http\\Controllers\\BirthdayController@schedulePreview',
        'namespace' => NULL,
        'prefix' => 'api/v1/birthdays',
        'where' => 
        array (
        ),
        'as' => 'generated::uTgcmwOG27ge07wB',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::kmdvsuomQ8MC87DU' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/birthdays/bulk-schedule',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\BirthdayController@bulkSchedule',
        'controller' => 'App\\Http\\Controllers\\BirthdayController@bulkSchedule',
        'namespace' => NULL,
        'prefix' => 'api/v1/birthdays',
        'where' => 
        array (
        ),
        'as' => 'generated::kmdvsuomQ8MC87DU',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::tZ4voLpBu7uMVBOc' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/birthdays/recognition-suggestions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\BirthdayController@recognitionSuggestions',
        'controller' => 'App\\Http\\Controllers\\BirthdayController@recognitionSuggestions',
        'namespace' => NULL,
        'prefix' => 'api/v1/birthdays',
        'where' => 
        array (
        ),
        'as' => 'generated::tZ4voLpBu7uMVBOc',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ombvf5fT2ZO2zK7Q' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/birthdays/process',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
          3 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\BirthdayController@processBirthdays',
        'controller' => 'App\\Http\\Controllers\\BirthdayController@processBirthdays',
        'namespace' => NULL,
        'prefix' => 'api/v1/birthdays',
        'where' => 
        array (
        ),
        'as' => 'generated::ombvf5fT2ZO2zK7Q',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::21j6WDwNhuoSxBJJ' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/birthdays/retry-failed',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
          3 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\BirthdayController@retryFailed',
        'controller' => 'App\\Http\\Controllers\\BirthdayController@retryFailed',
        'namespace' => NULL,
        'prefix' => 'api/v1/birthdays',
        'where' => 
        array (
        ),
        'as' => 'generated::21j6WDwNhuoSxBJJ',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::XQ7ZQrab0lf7d5QX' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/reports',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@index',
        'controller' => 'App\\Http\\Controllers\\ReportController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1/reports',
        'where' => 
        array (
        ),
        'as' => 'generated::XQ7ZQrab0lf7d5QX',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::aXeDjcf7fDBEldS3' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/reports/analytics',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@analytics',
        'controller' => 'App\\Http\\Controllers\\ReportController@analytics',
        'namespace' => NULL,
        'prefix' => 'api/v1/reports',
        'where' => 
        array (
        ),
        'as' => 'generated::aXeDjcf7fDBEldS3',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::VqVX7VDg6iQyQ7Tu' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/reports/custom',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@storeCustomReport',
        'controller' => 'App\\Http\\Controllers\\ReportController@storeCustomReport',
        'namespace' => NULL,
        'prefix' => 'api/v1/reports',
        'where' => 
        array (
        ),
        'as' => 'generated::VqVX7VDg6iQyQ7Tu',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::4pEH3eQ6wTMkllcT' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/reports/custom/{report}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@showCustomReport',
        'controller' => 'App\\Http\\Controllers\\ReportController@showCustomReport',
        'namespace' => NULL,
        'prefix' => 'api/v1/reports',
        'where' => 
        array (
        ),
        'as' => 'generated::4pEH3eQ6wTMkllcT',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::MJiSGzBxiYoSXYPR' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/reports/custom/{report}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@updateCustomReport',
        'controller' => 'App\\Http\\Controllers\\ReportController@updateCustomReport',
        'namespace' => NULL,
        'prefix' => 'api/v1/reports',
        'where' => 
        array (
        ),
        'as' => 'generated::MJiSGzBxiYoSXYPR',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::cf0msSG69wXPWQnO' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/v1/reports/custom/{report}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@deleteCustomReport',
        'controller' => 'App\\Http\\Controllers\\ReportController@deleteCustomReport',
        'namespace' => NULL,
        'prefix' => 'api/v1/reports',
        'where' => 
        array (
        ),
        'as' => 'generated::cf0msSG69wXPWQnO',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::dFBhWxYp7VEyHMXL' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/reports/preview',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@previewReport',
        'controller' => 'App\\Http\\Controllers\\ReportController@previewReport',
        'namespace' => NULL,
        'prefix' => 'api/v1/reports',
        'where' => 
        array (
        ),
        'as' => 'generated::dFBhWxYp7VEyHMXL',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::GzGVJGMe0HTFXccv' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/reports/fields',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@getAvailableFields',
        'controller' => 'App\\Http\\Controllers\\ReportController@getAvailableFields',
        'namespace' => NULL,
        'prefix' => 'api/v1/reports',
        'where' => 
        array (
        ),
        'as' => 'generated::GzGVJGMe0HTFXccv',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::7QnCGuBkwkl20uIq' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/reports/operators',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@getFilterOperators',
        'controller' => 'App\\Http\\Controllers\\ReportController@getFilterOperators',
        'namespace' => NULL,
        'prefix' => 'api/v1/reports',
        'where' => 
        array (
        ),
        'as' => 'generated::7QnCGuBkwkl20uIq',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::PlJvbPUBFtPypPvn' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/reports/validate',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@validateReportConfig',
        'controller' => 'App\\Http\\Controllers\\ReportController@validateReportConfig',
        'namespace' => NULL,
        'prefix' => 'api/v1/reports',
        'where' => 
        array (
        ),
        'as' => 'generated::PlJvbPUBFtPypPvn',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::P9fu6eyQZbYNWWfw' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/reports/export/pdf',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@exportPdf',
        'controller' => 'App\\Http\\Controllers\\ReportController@exportPdf',
        'namespace' => NULL,
        'prefix' => 'api/v1/reports',
        'where' => 
        array (
        ),
        'as' => 'generated::P9fu6eyQZbYNWWfw',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::6dtzOTsuBwyNUeIV' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/reports/export/excel',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@exportExcel',
        'controller' => 'App\\Http\\Controllers\\ReportController@exportExcel',
        'namespace' => NULL,
        'prefix' => 'api/v1/reports',
        'where' => 
        array (
        ),
        'as' => 'generated::6dtzOTsuBwyNUeIV',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::gh25j00rZxqCL28g' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/reports/export/csv',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@exportCsv',
        'controller' => 'App\\Http\\Controllers\\ReportController@exportCsv',
        'namespace' => NULL,
        'prefix' => 'api/v1/reports',
        'where' => 
        array (
        ),
        'as' => 'generated::gh25j00rZxqCL28g',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::vK45O7aR9mU1zw7C' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/messaging/conversations',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@index',
        'controller' => 'App\\Http\\Controllers\\MessagingController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1/messaging',
        'where' => 
        array (
        ),
        'as' => 'generated::vK45O7aR9mU1zw7C',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::U0NdikYENgvRiqGS' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/messaging/direct',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@startDirectConversation',
        'controller' => 'App\\Http\\Controllers\\MessagingController@startDirectConversation',
        'namespace' => NULL,
        'prefix' => 'api/v1/messaging',
        'where' => 
        array (
        ),
        'as' => 'generated::U0NdikYENgvRiqGS',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::BEescjevcBShXnU9' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/messaging/groups',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@createGroup',
        'controller' => 'App\\Http\\Controllers\\MessagingController@createGroup',
        'namespace' => NULL,
        'prefix' => 'api/v1/messaging',
        'where' => 
        array (
        ),
        'as' => 'generated::BEescjevcBShXnU9',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::j3BUheD3BnIETYRM' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/messaging/conversations/{conversation}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@showConversation',
        'controller' => 'App\\Http\\Controllers\\MessagingController@showConversation',
        'namespace' => NULL,
        'prefix' => 'api/v1/messaging',
        'where' => 
        array (
        ),
        'as' => 'generated::j3BUheD3BnIETYRM',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::3qApRQhy9CBlFcmX' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/messaging/conversations/{conversation}/messages',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@getMessages',
        'controller' => 'App\\Http\\Controllers\\MessagingController@getMessages',
        'namespace' => NULL,
        'prefix' => 'api/v1/messaging',
        'where' => 
        array (
        ),
        'as' => 'generated::3qApRQhy9CBlFcmX',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Vey2t0driASU2SpZ' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/messaging/conversations/{conversation}/messages',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@sendMessage',
        'controller' => 'App\\Http\\Controllers\\MessagingController@sendMessage',
        'namespace' => NULL,
        'prefix' => 'api/v1/messaging',
        'where' => 
        array (
        ),
        'as' => 'generated::Vey2t0driASU2SpZ',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::47Mny4nM1lYVakaU' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/messaging/conversations/{conversation}/mark-read',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@markAsRead',
        'controller' => 'App\\Http\\Controllers\\MessagingController@markAsRead',
        'namespace' => NULL,
        'prefix' => 'api/v1/messaging',
        'where' => 
        array (
        ),
        'as' => 'generated::47Mny4nM1lYVakaU',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::msE9RMwHzUTPdzzu' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/messaging/messages/{message}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@editMessage',
        'controller' => 'App\\Http\\Controllers\\MessagingController@editMessage',
        'namespace' => NULL,
        'prefix' => 'api/v1/messaging',
        'where' => 
        array (
        ),
        'as' => 'generated::msE9RMwHzUTPdzzu',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::rO8TmzV1yPKRfuPg' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/v1/messaging/messages/{message}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@deleteMessage',
        'controller' => 'App\\Http\\Controllers\\MessagingController@deleteMessage',
        'namespace' => NULL,
        'prefix' => 'api/v1/messaging',
        'where' => 
        array (
        ),
        'as' => 'generated::rO8TmzV1yPKRfuPg',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ORBp2yxQEts7WvVl' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/messaging/messages/{message}/reactions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@reactToMessage',
        'controller' => 'App\\Http\\Controllers\\MessagingController@reactToMessage',
        'namespace' => NULL,
        'prefix' => 'api/v1/messaging',
        'where' => 
        array (
        ),
        'as' => 'generated::ORBp2yxQEts7WvVl',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::CwiIBbsBclMHwLu2' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/messaging/messages/{message}/star',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@starMessage',
        'controller' => 'App\\Http\\Controllers\\MessagingController@starMessage',
        'namespace' => NULL,
        'prefix' => 'api/v1/messaging',
        'where' => 
        array (
        ),
        'as' => 'generated::CwiIBbsBclMHwLu2',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::3U3YxllqFSeehKLH' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/messaging/search',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@search',
        'controller' => 'App\\Http\\Controllers\\MessagingController@search',
        'namespace' => NULL,
        'prefix' => 'api/v1/messaging',
        'where' => 
        array (
        ),
        'as' => 'generated::3U3YxllqFSeehKLH',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::3UB0rQWAaHiXH7wB' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/shepherds',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\ShepherdController@index',
        'controller' => 'App\\Http\\Controllers\\ShepherdController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1/shepherds',
        'where' => 
        array (
        ),
        'as' => 'generated::3UB0rQWAaHiXH7wB',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::vwehVFUqL37LYCQt' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/shepherds',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\ShepherdController@store',
        'controller' => 'App\\Http\\Controllers\\ShepherdController@store',
        'namespace' => NULL,
        'prefix' => 'api/v1/shepherds',
        'where' => 
        array (
        ),
        'as' => 'generated::vwehVFUqL37LYCQt',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::7HSvh21VQzmMJZHY' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/shepherds/analytics',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\ShepherdController@analytics',
        'controller' => 'App\\Http\\Controllers\\ShepherdController@analytics',
        'namespace' => NULL,
        'prefix' => 'api/v1/shepherds',
        'where' => 
        array (
        ),
        'as' => 'generated::7HSvh21VQzmMJZHY',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::g9gL7tJhYxQf4tiN' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/shepherds/auto-assign',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\ShepherdController@autoAssign',
        'controller' => 'App\\Http\\Controllers\\ShepherdController@autoAssign',
        'namespace' => NULL,
        'prefix' => 'api/v1/shepherds',
        'where' => 
        array (
        ),
        'as' => 'generated::g9gL7tJhYxQf4tiN',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::08Hn6rOhB8SgED1O' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/shepherds/{shepherd}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\ShepherdController@show',
        'controller' => 'App\\Http\\Controllers\\ShepherdController@show',
        'namespace' => NULL,
        'prefix' => 'api/v1/shepherds',
        'where' => 
        array (
        ),
        'as' => 'generated::08Hn6rOhB8SgED1O',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::AxXQTn4KjJ2Rt0FV' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/shepherds/{shepherd}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\ShepherdController@update',
        'controller' => 'App\\Http\\Controllers\\ShepherdController@update',
        'namespace' => NULL,
        'prefix' => 'api/v1/shepherds',
        'where' => 
        array (
        ),
        'as' => 'generated::AxXQTn4KjJ2Rt0FV',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::wMKoFlFh0O4FX54A' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/v1/shepherds/{shepherd}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\ShepherdController@destroy',
        'controller' => 'App\\Http\\Controllers\\ShepherdController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/v1/shepherds',
        'where' => 
        array (
        ),
        'as' => 'generated::wMKoFlFh0O4FX54A',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::CTOPMReF3zzCV5b7' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/shepherds/{shepherd}/assign-member',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\ShepherdController@assignMember',
        'controller' => 'App\\Http\\Controllers\\ShepherdController@assignMember',
        'namespace' => NULL,
        'prefix' => 'api/v1/shepherds',
        'where' => 
        array (
        ),
        'as' => 'generated::CTOPMReF3zzCV5b7',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::2fNEQJcKd8h08XJh' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/shepherds/{shepherd}/unassign-member',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\ShepherdController@unassignMember',
        'controller' => 'App\\Http\\Controllers\\ShepherdController@unassignMember',
        'namespace' => NULL,
        'prefix' => 'api/v1/shepherds',
        'where' => 
        array (
        ),
        'as' => 'generated::2fNEQJcKd8h08XJh',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::FcLP23ltHSdfJYoW' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/service-units',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServiceUnitController@index',
        'controller' => 'App\\Http\\Controllers\\ServiceUnitController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1/service-units',
        'where' => 
        array (
        ),
        'as' => 'generated::FcLP23ltHSdfJYoW',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::pCuCMqpVJ3992FBh' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/service-units',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServiceUnitController@store',
        'controller' => 'App\\Http\\Controllers\\ServiceUnitController@store',
        'namespace' => NULL,
        'prefix' => 'api/v1/service-units',
        'where' => 
        array (
        ),
        'as' => 'generated::pCuCMqpVJ3992FBh',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Bf9bNXVo7VoiXEmz' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/service-units/analytics',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServiceUnitController@analytics',
        'controller' => 'App\\Http\\Controllers\\ServiceUnitController@analytics',
        'namespace' => NULL,
        'prefix' => 'api/v1/service-units',
        'where' => 
        array (
        ),
        'as' => 'generated::Bf9bNXVo7VoiXEmz',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::t0Aid19asZkxDmEw' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/service-units/{serviceUnit}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServiceUnitController@show',
        'controller' => 'App\\Http\\Controllers\\ServiceUnitController@show',
        'namespace' => NULL,
        'prefix' => 'api/v1/service-units',
        'where' => 
        array (
        ),
        'as' => 'generated::t0Aid19asZkxDmEw',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::EixZ41Qyn3uBHZeD' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/service-units/{serviceUnit}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServiceUnitController@update',
        'controller' => 'App\\Http\\Controllers\\ServiceUnitController@update',
        'namespace' => NULL,
        'prefix' => 'api/v1/service-units',
        'where' => 
        array (
        ),
        'as' => 'generated::EixZ41Qyn3uBHZeD',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::cGFGsAOKTb8mlTZ8' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/v1/service-units/{serviceUnit}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServiceUnitController@destroy',
        'controller' => 'App\\Http\\Controllers\\ServiceUnitController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/v1/service-units',
        'where' => 
        array (
        ),
        'as' => 'generated::cGFGsAOKTb8mlTZ8',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ODt1ttJMV7srDQop' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/service-units/{serviceUnit}/add-member',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServiceUnitController@addMember',
        'controller' => 'App\\Http\\Controllers\\ServiceUnitController@addMember',
        'namespace' => NULL,
        'prefix' => 'api/v1/service-units',
        'where' => 
        array (
        ),
        'as' => 'generated::ODt1ttJMV7srDQop',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::l3rquiZKNka3QFCm' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/v1/service-units/{serviceUnit}/remove-member',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServiceUnitController@removeMember',
        'controller' => 'App\\Http\\Controllers\\ServiceUnitController@removeMember',
        'namespace' => NULL,
        'prefix' => 'api/v1/service-units',
        'where' => 
        array (
        ),
        'as' => 'generated::l3rquiZKNka3QFCm',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::n6uTOequkvZCkRAC' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/settings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\SettingsController@index',
        'controller' => 'App\\Http\\Controllers\\SettingsController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1/settings',
        'where' => 
        array (
        ),
        'as' => 'generated::n6uTOequkvZCkRAC',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Bb9Ljion96IcQcJO' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/settings/general',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\SettingsController@updateGeneral',
        'controller' => 'App\\Http\\Controllers\\SettingsController@updateGeneral',
        'namespace' => NULL,
        'prefix' => 'api/v1/settings',
        'where' => 
        array (
        ),
        'as' => 'generated::Bb9Ljion96IcQcJO',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::3nh420LPDFHK1PXx' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/settings/email-templates',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\SettingsController@emailTemplates',
        'controller' => 'App\\Http\\Controllers\\SettingsController@emailTemplates',
        'namespace' => NULL,
        'prefix' => 'api/v1/settings',
        'where' => 
        array (
        ),
        'as' => 'generated::3nh420LPDFHK1PXx',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::wBavoY17XhC5y6oo' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/settings/email-templates/{template}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\SettingsController@updateEmailTemplate',
        'controller' => 'App\\Http\\Controllers\\SettingsController@updateEmailTemplate',
        'namespace' => NULL,
        'prefix' => 'api/v1/settings',
        'where' => 
        array (
        ),
        'as' => 'generated::wBavoY17XhC5y6oo',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::15mH5fujrtBz03mC' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/settings/audit-logs',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\SettingsController@auditLogs',
        'controller' => 'App\\Http\\Controllers\\SettingsController@auditLogs',
        'namespace' => NULL,
        'prefix' => 'api/v1/settings',
        'where' => 
        array (
        ),
        'as' => 'generated::15mH5fujrtBz03mC',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::1oA35A5wTQFHXzrd' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/settings/system-info',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\SettingsController@systemInfo',
        'controller' => 'App\\Http\\Controllers\\SettingsController@systemInfo',
        'namespace' => NULL,
        'prefix' => 'api/v1/settings',
        'where' => 
        array (
        ),
        'as' => 'generated::1oA35A5wTQFHXzrd',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::bkpQx6viyZ6kH4vD' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/settings/clear-cache',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\SettingsController@clearCache',
        'controller' => 'App\\Http\\Controllers\\SettingsController@clearCache',
        'namespace' => NULL,
        'prefix' => 'api/v1/settings',
        'where' => 
        array (
        ),
        'as' => 'generated::bkpQx6viyZ6kH4vD',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::sN1gq0bDl09JB4vp' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/qr-management/dashboard',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\QRManagementController@dashboard',
        'controller' => 'App\\Http\\Controllers\\QRManagementController@dashboard',
        'namespace' => NULL,
        'prefix' => 'api/v1/qr-management',
        'where' => 
        array (
        ),
        'as' => 'generated::sN1gq0bDl09JB4vp',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::404mVsZT9QBNGwpV' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/qr-management',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\QRManagementController@index',
        'controller' => 'App\\Http\\Controllers\\QRManagementController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1/qr-management',
        'where' => 
        array (
        ),
        'as' => 'generated::404mVsZT9QBNGwpV',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ztqUdzo4ctNoZbCK' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/qr-management/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\QRManagementController@create',
        'controller' => 'App\\Http\\Controllers\\QRManagementController@create',
        'namespace' => NULL,
        'prefix' => 'api/v1/qr-management',
        'where' => 
        array (
        ),
        'as' => 'generated::ztqUdzo4ctNoZbCK',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::9FHoNenKu8xr6ulp' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/qr-management',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\QRManagementController@store',
        'controller' => 'App\\Http\\Controllers\\QRManagementController@store',
        'namespace' => NULL,
        'prefix' => 'api/v1/qr-management',
        'where' => 
        array (
        ),
        'as' => 'generated::9FHoNenKu8xr6ulp',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::bHEC9UA8WDu2x0Db' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/qr-management/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\QRManagementController@show',
        'controller' => 'App\\Http\\Controllers\\QRManagementController@show',
        'namespace' => NULL,
        'prefix' => 'api/v1/qr-management',
        'where' => 
        array (
        ),
        'as' => 'generated::bHEC9UA8WDu2x0Db',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::D8C1ACgrPoFWPXYG' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/qr-management/{id}/revoke',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\QRManagementController@revoke',
        'controller' => 'App\\Http\\Controllers\\QRManagementController@revoke',
        'namespace' => NULL,
        'prefix' => 'api/v1/qr-management',
        'where' => 
        array (
        ),
        'as' => 'generated::D8C1ACgrPoFWPXYG',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::CCYj6PCezawlbwVP' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/qr-management/{id}/extend',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\QRManagementController@extend',
        'controller' => 'App\\Http\\Controllers\\QRManagementController@extend',
        'namespace' => NULL,
        'prefix' => 'api/v1/qr-management',
        'where' => 
        array (
        ),
        'as' => 'generated::CCYj6PCezawlbwVP',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ks6sy3JihBwZC8VB' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/qr-management/analytics/overview',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\QRManagementController@analytics',
        'controller' => 'App\\Http\\Controllers\\QRManagementController@analytics',
        'namespace' => NULL,
        'prefix' => 'api/v1/qr-management',
        'where' => 
        array (
        ),
        'as' => 'generated::ks6sy3JihBwZC8VB',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::tXxrlngSSoQfIF10' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/qr-management/{id}/analytics',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\QRManagementController@getAnalytics',
        'controller' => 'App\\Http\\Controllers\\QRManagementController@getAnalytics',
        'namespace' => NULL,
        'prefix' => 'api/v1/qr-management',
        'where' => 
        array (
        ),
        'as' => 'generated::tXxrlngSSoQfIF10',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::8yaigQdAWxk8y4hW' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/qr-management/{id}/scan-logs',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\QRManagementController@scanLogs',
        'controller' => 'App\\Http\\Controllers\\QRManagementController@scanLogs',
        'namespace' => NULL,
        'prefix' => 'api/v1/qr-management',
        'where' => 
        array (
        ),
        'as' => 'generated::8yaigQdAWxk8y4hW',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::MOJQPQsa8OLq8xyw' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/qr-management/settings/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\QRManagementController@settings',
        'controller' => 'App\\Http\\Controllers\\QRManagementController@settings',
        'namespace' => NULL,
        'prefix' => 'api/v1/qr-management',
        'where' => 
        array (
        ),
        'as' => 'generated::MOJQPQsa8OLq8xyw',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::b1dwkgcFgiZJFCof' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/qr-management/settings/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\QRManagementController@updateSettings',
        'controller' => 'App\\Http\\Controllers\\QRManagementController@updateSettings',
        'namespace' => NULL,
        'prefix' => 'api/v1/qr-management',
        'where' => 
        array (
        ),
        'as' => 'generated::b1dwkgcFgiZJFCof',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::HR0ubjXyvYNLOuAJ' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/qr-management/print/preview',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\QRManagementController@printPreview',
        'controller' => 'App\\Http\\Controllers\\QRManagementController@printPreview',
        'namespace' => NULL,
        'prefix' => 'api/v1/qr-management',
        'where' => 
        array (
        ),
        'as' => 'generated::HR0ubjXyvYNLOuAJ',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::7u6ay3APg7y2l1AK' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/qr-management/export/analytics',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\QRManagementController@exportAnalytics',
        'controller' => 'App\\Http\\Controllers\\QRManagementController@exportAnalytics',
        'namespace' => NULL,
        'prefix' => 'api/v1/qr-management',
        'where' => 
        array (
        ),
        'as' => 'generated::7u6ay3APg7y2l1AK',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Xj5xFBpJfNoyDuGG' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/qr-management/batch/generate',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\QRManagementController@generateBatch',
        'controller' => 'App\\Http\\Controllers\\QRManagementController@generateBatch',
        'namespace' => NULL,
        'prefix' => 'api/v1/qr-management',
        'where' => 
        array (
        ),
        'as' => 'generated::Xj5xFBpJfNoyDuGG',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::4vnyJG1Dgo2PRik1' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/qr-scan/scan',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\API\\QRScanController@scan',
        'controller' => 'App\\Http\\Controllers\\API\\QRScanController@scan',
        'namespace' => NULL,
        'prefix' => 'api/v1/qr-scan',
        'where' => 
        array (
        ),
        'as' => 'generated::4vnyJG1Dgo2PRik1',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::vIVUwn26m38mY1q2' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/qr-scan/validate',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\API\\QRScanController@validateQr',
        'controller' => 'App\\Http\\Controllers\\API\\QRScanController@validateQr',
        'namespace' => NULL,
        'prefix' => 'api/v1/qr-scan',
        'where' => 
        array (
        ),
        'as' => 'generated::vIVUwn26m38mY1q2',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::SLdesOihmzOVim21' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/qr-scan/history',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\API\\QRScanController@history',
        'controller' => 'App\\Http\\Controllers\\API\\QRScanController@history',
        'namespace' => NULL,
        'prefix' => 'api/v1/qr-scan',
        'where' => 
        array (
        ),
        'as' => 'generated::SLdesOihmzOVim21',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::3w5yCeNiJxhksxZk' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/qr-scan/sync-offline',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\API\\QRScanController@syncOffline',
        'controller' => 'App\\Http\\Controllers\\API\\QRScanController@syncOffline',
        'namespace' => NULL,
        'prefix' => 'api/v1/qr-scan',
        'where' => 
        array (
        ),
        'as' => 'generated::3w5yCeNiJxhksxZk',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ytob8AOUgU1lR5kQ' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/qr-scan/{id}/info',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\API\\QRScanController@info',
        'controller' => 'App\\Http\\Controllers\\API\\QRScanController@info',
        'namespace' => NULL,
        'prefix' => 'api/v1/qr-scan',
        'where' => 
        array (
        ),
        'as' => 'generated::ytob8AOUgU1lR5kQ',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::H0muDMa3IdsIFr0T' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/qr-scan/{id}/has-scanned',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\API\\QRScanController@hasScanned',
        'controller' => 'App\\Http\\Controllers\\API\\QRScanController@hasScanned',
        'namespace' => NULL,
        'prefix' => 'api/v1/qr-scan',
        'where' => 
        array (
        ),
        'as' => 'generated::H0muDMa3IdsIFr0T',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::2tsZthXBGRnnaEHb' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/qr-scan/active-service',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\API\\QRScanController@activeService',
        'controller' => 'App\\Http\\Controllers\\API\\QRScanController@activeService',
        'namespace' => NULL,
        'prefix' => 'api/v1/qr-scan',
        'where' => 
        array (
        ),
        'as' => 'generated::2tsZthXBGRnnaEHb',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::0OvgFkrQuUYI5RYK' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/qr-scan/{id}/report',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\API\\QRScanController@report',
        'controller' => 'App\\Http\\Controllers\\API\\QRScanController@report',
        'namespace' => NULL,
        'prefix' => 'api/v1/qr-scan',
        'where' => 
        array (
        ),
        'as' => 'generated::0OvgFkrQuUYI5RYK',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::lAaLT5Dg0a2xD4Zn' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/mobile/v1/register/member',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobileRegistrationController@registerMember',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobileRegistrationController@registerMember',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::lAaLT5Dg0a2xD4Zn',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::v41LRjPMi9tC2iTp' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/mobile/v1/register/visitor',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobileRegistrationController@registerVisitor',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobileRegistrationController@registerVisitor',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::v41LRjPMi9tC2iTp',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Zj77UdJaWEufTCSZ' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/mobile/v1/verify-otp',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobileRegistrationController@verifyOtp',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobileRegistrationController@verifyOtp',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::Zj77UdJaWEufTCSZ',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::lAdq1n00vC3IhQT7' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/mobile/v1/resend-otp',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobileRegistrationController@resendOtp',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobileRegistrationController@resendOtp',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::lAdq1n00vC3IhQT7',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::TlMxqmyGeNg9Bowr' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/mobile/v1/check-in/member',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobileCheckInController@memberCheckIn',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobileCheckInController@memberCheckIn',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::TlMxqmyGeNg9Bowr',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::IGoAW4JRWsiHQf5l' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/mobile/v1/check-in/service',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobileCheckInController@serviceCheckIn',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobileCheckInController@serviceCheckIn',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::IGoAW4JRWsiHQf5l',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::iuw7Kj7GCE3q32Kn' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/mobile/v1/check-in/family',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobileCheckInController@familyCheckIn',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobileCheckInController@familyCheckIn',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::iuw7Kj7GCE3q32Kn',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::z4pkq904KpXy8Rlv' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/mobile/v1/registration/status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobileRegistrationController@checkStatus',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobileRegistrationController@checkStatus',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::z4pkq904KpXy8Rlv',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::2jRBGrDuxCGuLekF' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/mobile/v1/qr-code/personal',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobileCheckInController@generatePersonalQr',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobileCheckInController@generatePersonalQr',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::2jRBGrDuxCGuLekF',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::5CF6V5FZcDKqNgV1' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/mobile/v1/payment/initiate',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobilePaymentController@initiatePayment',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobilePaymentController@initiatePayment',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::5CF6V5FZcDKqNgV1',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::U2bxS7y4SIoINyN3' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/mobile/v1/payment/verify',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobilePaymentController@verifyPayment',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobilePaymentController@verifyPayment',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::U2bxS7y4SIoINyN3',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::dy53pni1zsQ3LGsl' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/mobile/v1/payment/qr-details',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobilePaymentController@getPaymentQrDetails',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobilePaymentController@getPaymentQrDetails',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::dy53pni1zsQ3LGsl',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::zaCjbBIFnFNbGnyo' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/mobile/v1/payment/recurring/setup',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobilePaymentController@setupRecurringPayment',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobilePaymentController@setupRecurringPayment',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::zaCjbBIFnFNbGnyo',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::tUfc4wsCezMh1MOq' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/mobile/v1/payment/history',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobilePaymentController@paymentHistory',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobilePaymentController@paymentHistory',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::tUfc4wsCezMh1MOq',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::WPI3lU4LjzYKxlHi' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/mobile/v1/equipment/scan/{qrCode}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobileEquipmentController@scanEquipment',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobileEquipmentController@scanEquipment',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::WPI3lU4LjzYKxlHi',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::VkhxwS5xF33Ur7Qh' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/mobile/v1/equipment/checkout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobileEquipmentController@checkoutEquipment',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobileEquipmentController@checkoutEquipment',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::VkhxwS5xF33Ur7Qh',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::YhVEm2ckiiDb5d22' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/mobile/v1/equipment/return',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobileEquipmentController@returnEquipment',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobileEquipmentController@returnEquipment',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::YhVEm2ckiiDb5d22',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::jIBCfWId9l8K8CoM' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/mobile/v1/equipment/my-checkouts',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobileEquipmentController@myCheckouts',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobileEquipmentController@myCheckouts',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::jIBCfWId9l8K8CoM',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Wdv6RuN9ByLZYjWM' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/mobile/v1/equipment/report-issue',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobileEquipmentController@reportIssue',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobileEquipmentController@reportIssue',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::Wdv6RuN9ByLZYjWM',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::0KHHqbK0ia9cb84b' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/mobile/v1/shepherd/flock',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobileShepherdController@getMyFlock',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobileShepherdController@getMyFlock',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1/shepherd',
        'where' => 
        array (
        ),
        'as' => 'generated::0KHHqbK0ia9cb84b',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::u13AM8Q7EvvKG9fl' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/mobile/v1/shepherd/visit/record',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobileShepherdController@recordVisit',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobileShepherdController@recordVisit',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1/shepherd',
        'where' => 
        array (
        ),
        'as' => 'generated::u13AM8Q7EvvKG9fl',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::42eN897Fu4Rmfaai' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/mobile/v1/shepherd/visit/history',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobileShepherdController@visitHistory',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobileShepherdController@visitHistory',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1/shepherd',
        'where' => 
        array (
        ),
        'as' => 'generated::42eN897Fu4Rmfaai',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::84Y42DHnCLr4AGsT' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/mobile/v1/shepherd/flock/message',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobileShepherdController@messageFlock',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobileShepherdController@messageFlock',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1/shepherd',
        'where' => 
        array (
        ),
        'as' => 'generated::84Y42DHnCLr4AGsT',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::w0fW97tZwRZ8bzfK' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/mobile/v1/shepherd/performance',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobileShepherdController@getPerformanceDashboard',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobileShepherdController@getPerformanceDashboard',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1/shepherd',
        'where' => 
        array (
        ),
        'as' => 'generated::w0fW97tZwRZ8bzfK',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::aWOqfj63wRgaW81B' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/mobile/v1/service-unit/my-units',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobileServiceUnitController@getMyUnits',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobileServiceUnitController@getMyUnits',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1/service-unit',
        'where' => 
        array (
        ),
        'as' => 'generated::aWOqfj63wRgaW81B',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::3SLv5M81WbV2TlHK' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/mobile/v1/service-unit/{serviceUnit}/details',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobileServiceUnitController@show',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobileServiceUnitController@show',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1/service-unit',
        'where' => 
        array (
        ),
        'as' => 'generated::3SLv5M81WbV2TlHK',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::xCZzSFTEGrzYAeKE' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/mobile/v1/service-unit/{serviceUnit}/members',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobileServiceUnitController@getMembers',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobileServiceUnitController@getMembers',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1/service-unit',
        'where' => 
        array (
        ),
        'as' => 'generated::xCZzSFTEGrzYAeKE',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::mHRZdTnGc5Xq29Xp' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/mobile/v1/service-unit/{serviceUnit}/members',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobileServiceUnitController@addMember',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobileServiceUnitController@addMember',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1/service-unit',
        'where' => 
        array (
        ),
        'as' => 'generated::mHRZdTnGc5Xq29Xp',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::OfdrZWaeMf8XtC7K' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/mobile/v1/service-unit/{serviceUnit}/rosters',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobileServiceUnitController@getRosters',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobileServiceUnitController@getRosters',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1/service-unit',
        'where' => 
        array (
        ),
        'as' => 'generated::OfdrZWaeMf8XtC7K',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::dIndZ6BARlIVpKXO' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/mobile/v1/service-unit/{serviceUnit}/rosters',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobileServiceUnitController@createRoster',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobileServiceUnitController@createRoster',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1/service-unit',
        'where' => 
        array (
        ),
        'as' => 'generated::dIndZ6BARlIVpKXO',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::UcYwwVAhWfwe7NsW' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/mobile/v1/children/check-in',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobileChildrensController@checkIn',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobileChildrensController@checkIn',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1/children',
        'where' => 
        array (
        ),
        'as' => 'generated::UcYwwVAhWfwe7NsW',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::sRAcDex2VVC1BGLj' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/mobile/v1/children/check-out',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobileChildrensController@checkOut',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobileChildrensController@checkOut',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1/children',
        'where' => 
        array (
        ),
        'as' => 'generated::sRAcDex2VVC1BGLj',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::L2lEVrxX1wUaUa3J' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/mobile/v1/children/my-children',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobileChildrensController@getMyChildren',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobileChildrensController@getMyChildren',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1/children',
        'where' => 
        array (
        ),
        'as' => 'generated::L2lEVrxX1wUaUa3J',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::0a9sXG4Zcd1l4D66' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/mobile/v1/children/security-code/generate',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobileChildrensController@generateSecurityCode',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobileChildrensController@generateSecurityCode',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1/children',
        'where' => 
        array (
        ),
        'as' => 'generated::0a9sXG4Zcd1l4D66',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::A2ZyDgsYTphUXt0H' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/mobile/v1/children/incident/report',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobileChildrensController@reportIncident',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobileChildrensController@reportIncident',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1/children',
        'where' => 
        array (
        ),
        'as' => 'generated::A2ZyDgsYTphUXt0H',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::XyYMQMItYQrUXaS6' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/mobile/v1/children/attendance-history',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobileChildrensController@getChildAttendanceHistory',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobileChildrensController@getChildAttendanceHistory',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1/children',
        'where' => 
        array (
        ),
        'as' => 'generated::XyYMQMItYQrUXaS6',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Evjjpvh2G8rdkoza' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/mobile/v1/announcements',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobileContentController@getAnnouncements',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobileContentController@getAnnouncements',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::Evjjpvh2G8rdkoza',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::wd6ceVIv1rMGe4ix' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/mobile/v1/service-times',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobileContentController@getServiceTimes',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobileContentController@getServiceTimes',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::wd6ceVIv1rMGe4ix',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::jIhZIkb3wgLlwUoE' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/mobile/v1/church-info',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobileContentController@getChurchInfo',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobileContentController@getChurchInfo',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::jIhZIkb3wgLlwUoE',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::UVqvWVx0Qk1roGgK' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/mobile/v1/events/upcoming',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobileContentController@getUpcomingEvents',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobileContentController@getUpcomingEvents',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::UVqvWVx0Qk1roGgK',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::M8cqAwNEXFzq4CiJ' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/mobile/v1/events/{eventId}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobileContentController@getEventDetails',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobileContentController@getEventDetails',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::M8cqAwNEXFzq4CiJ',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::2xhGKLNuTSrFO8m7' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/mobile/v1/search',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobileContentController@search',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobileContentController@search',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::2xhGKLNuTSrFO8m7',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.mobile.payment.callback' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/mobile/v1/payment/callback',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Mobile\\MobilePaymentController@paymentCallback',
        'controller' => 'App\\Http\\Controllers\\Mobile\\MobilePaymentController@paymentCallback',
        'namespace' => NULL,
        'prefix' => 'api/mobile/v1',
        'where' => 
        array (
        ),
        'as' => 'api.mobile.payment.callback',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::FGZzBfHE5d9bCGUP' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '/',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:44:"function () {
    return \\view(\'welcome\');
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000009510000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::FGZzBfHE5d9bCGUP',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
          2 => 'throttle:5,1',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\AuthController@showLoginForm',
        'controller' => 'App\\Http\\Controllers\\Auth\\AuthController@showLoginForm',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'login',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::45MJNujxKvJAZQfW' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
          2 => 'throttle:5,1',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\AuthController@login',
        'controller' => 'App\\Http\\Controllers\\Auth\\AuthController@login',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::45MJNujxKvJAZQfW',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'register' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'register',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
          2 => 'throttle:5,1',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\AuthController@showRegisterForm',
        'controller' => 'App\\Http\\Controllers\\Auth\\AuthController@showRegisterForm',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'register',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::3Q9kQ5IQT11eVHqu' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'register',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
          2 => 'throttle:5,1',
          3 => 'throttle:3,1',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\AuthController@register',
        'controller' => 'App\\Http\\Controllers\\Auth\\AuthController@register',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::3Q9kQ5IQT11eVHqu',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.request' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'forgot-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
          2 => 'throttle:5,1',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\AuthController@showForgotPasswordForm',
        'controller' => 'App\\Http\\Controllers\\Auth\\AuthController@showForgotPasswordForm',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.request',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.email' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'forgot-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
          2 => 'throttle:5,1',
          3 => 'throttle:3,1',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\AuthController@sendResetLink',
        'controller' => 'App\\Http\\Controllers\\Auth\\AuthController@sendResetLink',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.email',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.reset' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'reset-password/{token}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
          2 => 'throttle:5,1',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\AuthController@showResetForm',
        'controller' => 'App\\Http\\Controllers\\Auth\\AuthController@showResetForm',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.reset',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'reset-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
          2 => 'throttle:5,1',
          3 => 'throttle:3,1',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\AuthController@resetPassword',
        'controller' => 'App\\Http\\Controllers\\Auth\\AuthController@resetPassword',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'logout' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'logout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\AuthController@logout',
        'controller' => 'App\\Http\\Controllers\\Auth\\AuthController@logout',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'logout',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dashboard' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'dashboard',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\DashboardController@index',
        'controller' => 'App\\Http\\Controllers\\DashboardController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'dashboard',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dashboard.quick-action-data' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'dashboard/quick-action-data',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\DashboardController@getQuickActionData',
        'controller' => 'App\\Http\\Controllers\\DashboardController@getQuickActionData',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'dashboard.quick-action-data',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'profile' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'profile',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\DashboardController@profile',
        'controller' => 'App\\Http\\Controllers\\DashboardController@profile',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'profile',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'profile.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'profile',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\DashboardController@updateProfile',
        'controller' => 'App\\Http\\Controllers\\DashboardController@updateProfile',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'profile.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'notifications.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'notifications',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\NotificationController@index',
        'controller' => 'App\\Http\\Controllers\\NotificationController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'notifications.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'notifications.unread' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'notifications/unread',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\NotificationController@unread',
        'controller' => 'App\\Http\\Controllers\\NotificationController@unread',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'notifications.unread',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'notifications.mark-as-read' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'notifications/{notification}/mark-as-read',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\NotificationController@markAsRead',
        'controller' => 'App\\Http\\Controllers\\NotificationController@markAsRead',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'notifications.mark-as-read',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'notifications.mark-all-read' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'notifications/mark-all-read',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\NotificationController@markAllAsRead',
        'controller' => 'App\\Http\\Controllers\\NotificationController@markAllAsRead',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'notifications.mark-all-read',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'notifications.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'notifications/{notification}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\NotificationController@destroy',
        'controller' => 'App\\Http\\Controllers\\NotificationController@destroy',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'notifications.destroy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'notifications.delete-all-read' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'notifications/delete-all-read',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\NotificationController@deleteAllRead',
        'controller' => 'App\\Http\\Controllers\\NotificationController@deleteAllRead',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'notifications.delete-all-read',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'notifications.preferences' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'notifications/preferences',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\NotificationController@preferences',
        'controller' => 'App\\Http\\Controllers\\NotificationController@preferences',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'notifications.preferences',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'notifications.update-preferences' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'notifications/preferences',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\NotificationController@updatePreferences',
        'controller' => 'App\\Http\\Controllers\\NotificationController@updatePreferences',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'notifications.update-preferences',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'members.statistics' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'members/statistics',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\MemberController@statistics',
        'controller' => 'App\\Http\\Controllers\\MemberController@statistics',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'members.statistics',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'members.export' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'members/export',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\MemberController@export',
        'controller' => 'App\\Http\\Controllers\\MemberController@export',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'members.export',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'members.search' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'members/search',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\MemberController@search',
        'controller' => 'App\\Http\\Controllers\\MemberController@search',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'members.search',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'members.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'members',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'as' => 'members.index',
        'uses' => 'App\\Http\\Controllers\\MemberController@index',
        'controller' => 'App\\Http\\Controllers\\MemberController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'members.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'members/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'as' => 'members.create',
        'uses' => 'App\\Http\\Controllers\\MemberController@create',
        'controller' => 'App\\Http\\Controllers\\MemberController@create',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'members.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'members',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'as' => 'members.store',
        'uses' => 'App\\Http\\Controllers\\MemberController@store',
        'controller' => 'App\\Http\\Controllers\\MemberController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'members.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'members/{member}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'as' => 'members.show',
        'uses' => 'App\\Http\\Controllers\\MemberController@show',
        'controller' => 'App\\Http\\Controllers\\MemberController@show',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'members.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'members/{member}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'as' => 'members.edit',
        'uses' => 'App\\Http\\Controllers\\MemberController@edit',
        'controller' => 'App\\Http\\Controllers\\MemberController@edit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'members.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'members/{member}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'as' => 'members.update',
        'uses' => 'App\\Http\\Controllers\\MemberController@update',
        'controller' => 'App\\Http\\Controllers\\MemberController@update',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'members.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'members/{member}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'as' => 'members.destroy',
        'uses' => 'App\\Http\\Controllers\\MemberController@destroy',
        'controller' => 'App\\Http\\Controllers\\MemberController@destroy',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'members.bulk-action' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'members/bulk-action',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\MemberController@bulkAction',
        'controller' => 'App\\Http\\Controllers\\MemberController@bulkAction',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'members.bulk-action',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'members.delete-photo' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'members/{member}/photo',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\MemberController@deletePhoto',
        'controller' => 'App\\Http\\Controllers\\MemberController@deletePhoto',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'members.delete-photo',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'attendance.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'attendance',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@index',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'attendance.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'attendance.mark' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'attendance/mark',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@mark',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@mark',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'attendance.mark',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'attendance.bulk' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'attendance/bulk',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@bulkStore',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@bulkStore',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'attendance.bulk',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'attendance.reports' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'attendance/reports',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@reports',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@reports',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'attendance.reports',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'attendance.export' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'attendance/export',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@export',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@export',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'attendance.export',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'attendance.leaderboard' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'attendance/leaderboard',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@leaderboard',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@leaderboard',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'attendance.leaderboard',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'attendance.live' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'attendance/live',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@live',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@live',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'attendance.live',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'attendance.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'attendance/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@create',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@create',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'attendance.create',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'attendance.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'attendance',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@store',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'attendance.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'attendance.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'attendance/{attendance}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@show',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@show',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'attendance.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'attendance.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'attendance/{attendance}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@edit',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@edit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'attendance.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'attendance.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'attendance/{attendance}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@update',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@update',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'attendance.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'attendance.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'attendance/{attendance}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@destroy',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@destroy',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'attendance.destroy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'transactions.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'transactions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\TransactionController@index',
        'controller' => 'App\\Http\\Controllers\\TransactionController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'transactions.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'transactions.reports' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'transactions/reports',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\TransactionController@reports',
        'controller' => 'App\\Http\\Controllers\\TransactionController@reports',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'transactions.reports',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'transactions.export' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'transactions/export',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\TransactionController@export',
        'controller' => 'App\\Http\\Controllers\\TransactionController@export',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'transactions.export',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'transactions.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'transactions/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\TransactionController@create',
        'controller' => 'App\\Http\\Controllers\\TransactionController@create',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'transactions.create',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'transactions.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'transactions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\TransactionController@store',
        'controller' => 'App\\Http\\Controllers\\TransactionController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'transactions.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'transactions.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'transactions/{transaction}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\TransactionController@show',
        'controller' => 'App\\Http\\Controllers\\TransactionController@show',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'transactions.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'transactions.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'transactions/{transaction}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\TransactionController@edit',
        'controller' => 'App\\Http\\Controllers\\TransactionController@edit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'transactions.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'transactions.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'transactions/{transaction}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\TransactionController@update',
        'controller' => 'App\\Http\\Controllers\\TransactionController@update',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'transactions.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'transactions.deleteReceipt' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'transactions/{transaction}/receipt',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\TransactionController@deleteReceipt',
        'controller' => 'App\\Http\\Controllers\\TransactionController@deleteReceipt',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'transactions.deleteReceipt',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'transactions.pending' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'transactions/pending',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\TransactionController@pending',
        'controller' => 'App\\Http\\Controllers\\TransactionController@pending',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'transactions.pending',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'transactions.approve' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'transactions/{transaction}/approve',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\TransactionController@approve',
        'controller' => 'App\\Http\\Controllers\\TransactionController@approve',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'transactions.approve',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'transactions.reject' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'transactions/{transaction}/reject',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\TransactionController@reject',
        'controller' => 'App\\Http\\Controllers\\TransactionController@reject',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'transactions.reject',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'transactions.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'transactions/{transaction}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\TransactionController@destroy',
        'controller' => 'App\\Http\\Controllers\\TransactionController@destroy',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'transactions.destroy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'visitors.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'visitors',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\VisitorController@index',
        'controller' => 'App\\Http\\Controllers\\VisitorController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'visitors.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'visitors.eligible' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'visitors/eligible',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\VisitorController@eligible',
        'controller' => 'App\\Http\\Controllers\\VisitorController@eligible',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'visitors.eligible',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'visitors.followUp' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'visitors/follow-up',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\VisitorController@followUp',
        'controller' => 'App\\Http\\Controllers\\VisitorController@followUp',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'visitors.followUp',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'visitors.reports' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'visitors/reports',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\VisitorController@reports',
        'controller' => 'App\\Http\\Controllers\\VisitorController@reports',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'visitors.reports',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'visitors.export' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'visitors/export',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\VisitorController@export',
        'controller' => 'App\\Http\\Controllers\\VisitorController@export',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'visitors.export',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'visitors.search' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'visitors/search',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\VisitorController@search',
        'controller' => 'App\\Http\\Controllers\\VisitorController@search',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'visitors.search',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'visitors.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'visitors/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\VisitorController@create',
        'controller' => 'App\\Http\\Controllers\\VisitorController@create',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'visitors.create',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'visitors.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'visitors',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\VisitorController@store',
        'controller' => 'App\\Http\\Controllers\\VisitorController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'visitors.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'visitors.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'visitors/{visitor}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\VisitorController@show',
        'controller' => 'App\\Http\\Controllers\\VisitorController@show',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'visitors.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'visitors.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'visitors/{visitor}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\VisitorController@edit',
        'controller' => 'App\\Http\\Controllers\\VisitorController@edit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'visitors.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'visitors.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'visitors/{visitor}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\VisitorController@update',
        'controller' => 'App\\Http\\Controllers\\VisitorController@update',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'visitors.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'visitors.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'visitors/{visitor}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\VisitorController@destroy',
        'controller' => 'App\\Http\\Controllers\\VisitorController@destroy',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'visitors.destroy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'visitors.recordVisit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'visitors/{visitor}/record-visit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\VisitorController@recordVisit',
        'controller' => 'App\\Http\\Controllers\\VisitorController@recordVisit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'visitors.recordVisit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'visitors.convert.form' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'visitors/{visitor}/convert',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\VisitorController@convertForm',
        'controller' => 'App\\Http\\Controllers\\VisitorController@convertForm',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'visitors.convert.form',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'visitors.convert' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'visitors/{visitor}/convert',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\VisitorController@convert',
        'controller' => 'App\\Http\\Controllers\\VisitorController@convert',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'visitors.convert',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'visitors.markInactive' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'visitors/{visitor}/mark-inactive',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\VisitorController@markInactive',
        'controller' => 'App\\Http\\Controllers\\VisitorController@markInactive',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'visitors.markInactive',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'sms.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'sms',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\SmsBroadcastController@index',
        'controller' => 'App\\Http\\Controllers\\SmsBroadcastController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'sms.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'sms.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'sms/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\SmsBroadcastController@create',
        'controller' => 'App\\Http\\Controllers\\SmsBroadcastController@create',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'sms.create',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'sms.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'sms',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\SmsBroadcastController@store',
        'controller' => 'App\\Http\\Controllers\\SmsBroadcastController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'sms.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'sms.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'sms/{broadcast}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\SmsBroadcastController@show',
        'controller' => 'App\\Http\\Controllers\\SmsBroadcastController@show',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'sms.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'sms.send' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'sms/{broadcast}/send',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\SmsBroadcastController@send',
        'controller' => 'App\\Http\\Controllers\\SmsBroadcastController@send',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'sms.send',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'sms.status' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'sms/{broadcast}/status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\SmsBroadcastController@status',
        'controller' => 'App\\Http\\Controllers\\SmsBroadcastController@status',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'sms.status',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'equipment.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'equipment',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\EquipmentController@index',
        'controller' => 'App\\Http\\Controllers\\EquipmentController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'equipment.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'equipment.maintenance' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'equipment/maintenance',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\EquipmentController@maintenance',
        'controller' => 'App\\Http\\Controllers\\EquipmentController@maintenance',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'equipment.maintenance',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'equipment.reports' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'equipment/reports',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\EquipmentController@reports',
        'controller' => 'App\\Http\\Controllers\\EquipmentController@reports',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'equipment.reports',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'equipment.export' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'equipment/export',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\EquipmentController@export',
        'controller' => 'App\\Http\\Controllers\\EquipmentController@export',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'equipment.export',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'equipment.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'equipment/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\EquipmentController@create',
        'controller' => 'App\\Http\\Controllers\\EquipmentController@create',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'equipment.create',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'equipment.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'equipment',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\EquipmentController@store',
        'controller' => 'App\\Http\\Controllers\\EquipmentController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'equipment.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'equipment.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'equipment/{equipment}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\EquipmentController@show',
        'controller' => 'App\\Http\\Controllers\\EquipmentController@show',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'equipment.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'equipment.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'equipment/{equipment}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\EquipmentController@edit',
        'controller' => 'App\\Http\\Controllers\\EquipmentController@edit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'equipment.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'equipment.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'equipment/{equipment}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\EquipmentController@update',
        'controller' => 'App\\Http\\Controllers\\EquipmentController@update',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'equipment.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'equipment.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'equipment/{equipment}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\EquipmentController@destroy',
        'controller' => 'App\\Http\\Controllers\\EquipmentController@destroy',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'equipment.destroy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'equipment.maintenance.form' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'equipment/{equipment}/maintenance-form',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\EquipmentController@maintenanceForm',
        'controller' => 'App\\Http\\Controllers\\EquipmentController@maintenanceForm',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'equipment.maintenance.form',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'equipment.maintenance.record' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'equipment/{equipment}/maintenance',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\EquipmentController@recordMaintenance',
        'controller' => 'App\\Http\\Controllers\\EquipmentController@recordMaintenance',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'equipment.maintenance.record',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'equipment.maintenance.schedule' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'equipment/{equipment}/schedule-maintenance',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\EquipmentController@scheduleMaintenance',
        'controller' => 'App\\Http\\Controllers\\EquipmentController@scheduleMaintenance',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'equipment.maintenance.schedule',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'shepherds.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'shepherds',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\ShepherdController@index',
        'controller' => 'App\\Http\\Controllers\\ShepherdController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'shepherds.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'shepherds.analytics' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'shepherds/analytics',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\ShepherdController@analytics',
        'controller' => 'App\\Http\\Controllers\\ShepherdController@analytics',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'shepherds.analytics',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'shepherds.export' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'shepherds/export',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\ShepherdController@export',
        'controller' => 'App\\Http\\Controllers\\ShepherdController@export',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'shepherds.export',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'shepherds.auto-assign' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'shepherds/auto-assign',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\ShepherdController@autoAssign',
        'controller' => 'App\\Http\\Controllers\\ShepherdController@autoAssign',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'shepherds.auto-assign',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'shepherds.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'shepherds/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\ShepherdController@create',
        'controller' => 'App\\Http\\Controllers\\ShepherdController@create',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'shepherds.create',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'shepherds.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'shepherds',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\ShepherdController@store',
        'controller' => 'App\\Http\\Controllers\\ShepherdController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'shepherds.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'shepherds.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'shepherds/{shepherd}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\ShepherdController@show',
        'controller' => 'App\\Http\\Controllers\\ShepherdController@show',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'shepherds.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'shepherds.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'shepherds/{shepherd}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\ShepherdController@edit',
        'controller' => 'App\\Http\\Controllers\\ShepherdController@edit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'shepherds.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'shepherds.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'shepherds/{shepherd}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\ShepherdController@update',
        'controller' => 'App\\Http\\Controllers\\ShepherdController@update',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'shepherds.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'shepherds.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'shepherds/{shepherd}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\ShepherdController@destroy',
        'controller' => 'App\\Http\\Controllers\\ShepherdController@destroy',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'shepherds.destroy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'shepherds.manage-flock' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'shepherds/{shepherd}/manage-flock',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\ShepherdController@manageFlock',
        'controller' => 'App\\Http\\Controllers\\ShepherdController@manageFlock',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'shepherds.manage-flock',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'shepherds.assign-member' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'shepherds/{shepherd}/assign-member',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\ShepherdController@assignMember',
        'controller' => 'App\\Http\\Controllers\\ShepherdController@assignMember',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'shepherds.assign-member',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'shepherds.unassign-member' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'shepherds/{shepherd}/unassign-member',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\ShepherdController@unassignMember',
        'controller' => 'App\\Http\\Controllers\\ShepherdController@unassignMember',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'shepherds.unassign-member',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'shepherds.visitations' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'shepherds/{shepherd}/visitations',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\ShepherdController@visitations',
        'controller' => 'App\\Http\\Controllers\\ShepherdController@visitations',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'shepherds.visitations',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'shepherds.create-visitation' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'shepherds/{shepherd}/create-visitation',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\ShepherdController@createVisitation',
        'controller' => 'App\\Http\\Controllers\\ShepherdController@createVisitation',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'shepherds.create-visitation',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'shepherds.store-visitation' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'shepherds/{shepherd}/visitations',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\ShepherdController@storeVisitation',
        'controller' => 'App\\Http\\Controllers\\ShepherdController@storeVisitation',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'shepherds.store-visitation',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'shepherds.meetings' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'shepherds/{shepherd}/meetings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\ShepherdController@meetings',
        'controller' => 'App\\Http\\Controllers\\ShepherdController@meetings',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'shepherds.meetings',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'shepherds.create-meeting' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'shepherds/{shepherd}/create-meeting',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\ShepherdController@createMeeting',
        'controller' => 'App\\Http\\Controllers\\ShepherdController@createMeeting',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'shepherds.create-meeting',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'shepherds.store-meeting' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'shepherds/{shepherd}/meetings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\ShepherdController@storeMeeting',
        'controller' => 'App\\Http\\Controllers\\ShepherdController@storeMeeting',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'shepherds.store-meeting',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'shepherds.reports' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'shepherds/{shepherd}/reports',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\ShepherdController@reports',
        'controller' => 'App\\Http\\Controllers\\ShepherdController@reports',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'shepherds.reports',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'service-units.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'service-units',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServiceUnitController@index',
        'controller' => 'App\\Http\\Controllers\\ServiceUnitController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'service-units.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'service-units.analytics' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'service-units/analytics',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServiceUnitController@analytics',
        'controller' => 'App\\Http\\Controllers\\ServiceUnitController@analytics',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'service-units.analytics',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'service-units.export' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'service-units/export',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServiceUnitController@export',
        'controller' => 'App\\Http\\Controllers\\ServiceUnitController@export',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'service-units.export',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'service-units.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'service-units/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServiceUnitController@create',
        'controller' => 'App\\Http\\Controllers\\ServiceUnitController@create',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'service-units.create',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'service-units.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'service-units',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServiceUnitController@store',
        'controller' => 'App\\Http\\Controllers\\ServiceUnitController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'service-units.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'service-units.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'service-units/{serviceUnit}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServiceUnitController@show',
        'controller' => 'App\\Http\\Controllers\\ServiceUnitController@show',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'service-units.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'service-units.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'service-units/{serviceUnit}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServiceUnitController@edit',
        'controller' => 'App\\Http\\Controllers\\ServiceUnitController@edit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'service-units.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'service-units.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'service-units/{serviceUnit}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServiceUnitController@update',
        'controller' => 'App\\Http\\Controllers\\ServiceUnitController@update',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'service-units.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'service-units.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'service-units/{serviceUnit}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServiceUnitController@destroy',
        'controller' => 'App\\Http\\Controllers\\ServiceUnitController@destroy',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'service-units.destroy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'service-units.manage-members' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'service-units/{serviceUnit}/manage-members',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServiceUnitController@manageMembers',
        'controller' => 'App\\Http\\Controllers\\ServiceUnitController@manageMembers',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'service-units.manage-members',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'service-units.add-member' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'service-units/{serviceUnit}/add-member',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServiceUnitController@addMember',
        'controller' => 'App\\Http\\Controllers\\ServiceUnitController@addMember',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'service-units.add-member',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'service-units.remove-member' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'service-units/{serviceUnit}/remove-member',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServiceUnitController@removeMember',
        'controller' => 'App\\Http\\Controllers\\ServiceUnitController@removeMember',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'service-units.remove-member',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'service-units.duty-rosters' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'service-units/{serviceUnit}/duty-rosters',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServiceUnitController@dutyRosters',
        'controller' => 'App\\Http\\Controllers\\ServiceUnitController@dutyRosters',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'service-units.duty-rosters',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'service-units.create-duty-roster' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'service-units/{serviceUnit}/create-duty-roster',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServiceUnitController@createDutyRoster',
        'controller' => 'App\\Http\\Controllers\\ServiceUnitController@createDutyRoster',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'service-units.create-duty-roster',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'service-units.store-duty-roster' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'service-units/{serviceUnit}/duty-rosters',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServiceUnitController@storeDutyRoster',
        'controller' => 'App\\Http\\Controllers\\ServiceUnitController@storeDutyRoster',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'service-units.store-duty-roster',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'service-units.publish-duty-roster' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'duty-rosters/{dutyRoster}/publish',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServiceUnitController@publishDutyRoster',
        'controller' => 'App\\Http\\Controllers\\ServiceUnitController@publishDutyRoster',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'service-units.publish-duty-roster',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'programs.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'programs',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ProgramController@index',
        'controller' => 'App\\Http\\Controllers\\ProgramController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'programs.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'programs.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'programs/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ProgramController@create',
        'controller' => 'App\\Http\\Controllers\\ProgramController@create',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'programs.create',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'programs.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'programs',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ProgramController@store',
        'controller' => 'App\\Http\\Controllers\\ProgramController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'programs.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'programs.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'programs/{program}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ProgramController@show',
        'controller' => 'App\\Http\\Controllers\\ProgramController@show',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'programs.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'programs.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'programs/{program}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ProgramController@edit',
        'controller' => 'App\\Http\\Controllers\\ProgramController@edit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'programs.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'programs.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'programs/{program}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ProgramController@update',
        'controller' => 'App\\Http\\Controllers\\ProgramController@update',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'programs.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'programs.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'programs/{program}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ProgramController@destroy',
        'controller' => 'App\\Http\\Controllers\\ProgramController@destroy',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'programs.destroy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'programs.publish' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'programs/{program}/publish',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ProgramController@publish',
        'controller' => 'App\\Http\\Controllers\\ProgramController@publish',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'programs.publish',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'programs.start' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'programs/{program}/start',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ProgramController@start',
        'controller' => 'App\\Http\\Controllers\\ProgramController@start',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'programs.start',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'programs.complete' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'programs/{program}/complete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ProgramController@complete',
        'controller' => 'App\\Http\\Controllers\\ProgramController@complete',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'programs.complete',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'programs.cancel' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'programs/{program}/cancel',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ProgramController@cancel',
        'controller' => 'App\\Http\\Controllers\\ProgramController@cancel',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'programs.cancel',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'programs.manage-registrations' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'programs/{program}/registrations',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ProgramController@manageRegistrations',
        'controller' => 'App\\Http\\Controllers\\ProgramController@manageRegistrations',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'programs.manage-registrations',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'programs.check-in' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'programs/registrations/{registration}/check-in',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ProgramController@checkIn',
        'controller' => 'App\\Http\\Controllers\\ProgramController@checkIn',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'programs.check-in',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'programs.manage-sessions' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'programs/{program}/sessions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ProgramController@manageSessions',
        'controller' => 'App\\Http\\Controllers\\ProgramController@manageSessions',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'programs.manage-sessions',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'programs.store-session' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'programs/{program}/sessions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ProgramController@storeSession',
        'controller' => 'App\\Http\\Controllers\\ProgramController@storeSession',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'programs.store-session',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'programs.update-session' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'programs/sessions/{session}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ProgramController@updateSession',
        'controller' => 'App\\Http\\Controllers\\ProgramController@updateSession',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'programs.update-session',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'programs.destroy-session' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'programs/sessions/{session}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ProgramController@destroySession',
        'controller' => 'App\\Http\\Controllers\\ProgramController@destroySession',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'programs.destroy-session',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'programs.analytics' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'programs/{program}/analytics',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ProgramController@analytics',
        'controller' => 'App\\Http\\Controllers\\ProgramController@analytics',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'programs.analytics',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'programs.registration-form' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'programs/{program}/register',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\ProgramController@showRegistrationForm',
        'controller' => 'App\\Http\\Controllers\\ProgramController@showRegistrationForm',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'programs.registration-form',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'programs.register' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'programs/{program}/register',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\ProgramController@register',
        'controller' => 'App\\Http\\Controllers\\ProgramController@register',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'programs.register',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'programs.registration-success' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'programs/registrations/{registration}/success',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\ProgramController@registrationSuccess',
        'controller' => 'App\\Http\\Controllers\\ProgramController@registrationSuccess',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'programs.registration-success',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'services.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'services',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServicePlanningController@index',
        'controller' => 'App\\Http\\Controllers\\ServicePlanningController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'services.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'services.calendar' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'services/calendar',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServicePlanningController@calendar',
        'controller' => 'App\\Http\\Controllers\\ServicePlanningController@calendar',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'services.calendar',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'services.sermon-library' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'services/sermon-library',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServicePlanningController@sermonLibrary',
        'controller' => 'App\\Http\\Controllers\\ServicePlanningController@sermonLibrary',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'services.sermon-library',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'services.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'services/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServicePlanningController@create',
        'controller' => 'App\\Http\\Controllers\\ServicePlanningController@create',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'services.create',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'services.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'services',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServicePlanningController@store',
        'controller' => 'App\\Http\\Controllers\\ServicePlanningController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'services.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'services.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'services/{service}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServicePlanningController@show',
        'controller' => 'App\\Http\\Controllers\\ServicePlanningController@show',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'services.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'services.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'services/{service}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServicePlanningController@edit',
        'controller' => 'App\\Http\\Controllers\\ServicePlanningController@edit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'services.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'services.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'services/{service}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServicePlanningController@update',
        'controller' => 'App\\Http\\Controllers\\ServicePlanningController@update',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'services.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'services.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'services/{service}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServicePlanningController@destroy',
        'controller' => 'App\\Http\\Controllers\\ServicePlanningController@destroy',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'services.destroy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'services.publish' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'services/{service}/publish',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServicePlanningController@publish',
        'controller' => 'App\\Http\\Controllers\\ServicePlanningController@publish',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'services.publish',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'services.start' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'services/{service}/start',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServicePlanningController@start',
        'controller' => 'App\\Http\\Controllers\\ServicePlanningController@start',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'services.start',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'services.complete' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'services/{service}/complete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServicePlanningController@complete',
        'controller' => 'App\\Http\\Controllers\\ServicePlanningController@complete',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'services.complete',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'services.cancel' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'services/{service}/cancel',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServicePlanningController@cancel',
        'controller' => 'App\\Http\\Controllers\\ServicePlanningController@cancel',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'services.cancel',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'services.duplicate' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'services/{service}/duplicate',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServicePlanningController@duplicate',
        'controller' => 'App\\Http\\Controllers\\ServicePlanningController@duplicate',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'services.duplicate',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'services.worship-plan' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'services/{service}/worship-plan',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServicePlanningController@manageWorshipPlan',
        'controller' => 'App\\Http\\Controllers\\ServicePlanningController@manageWorshipPlan',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'services.worship-plan',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'services.store-worship-item' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'services/{service}/worship-plan',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServicePlanningController@storeWorshipPlanItem',
        'controller' => 'App\\Http\\Controllers\\ServicePlanningController@storeWorshipPlanItem',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'services.store-worship-item',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'services.update-worship-item' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'services/worship-plan/{item}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServicePlanningController@updateWorshipPlanItem',
        'controller' => 'App\\Http\\Controllers\\ServicePlanningController@updateWorshipPlanItem',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'services.update-worship-item',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'services.destroy-worship-item' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'services/worship-plan/{item}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServicePlanningController@destroyWorshipPlanItem',
        'controller' => 'App\\Http\\Controllers\\ServicePlanningController@destroyWorshipPlanItem',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'services.destroy-worship-item',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'services.reorder-worship-plan' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'services/{service}/worship-plan/reorder',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServicePlanningController@reorderWorshipPlan',
        'controller' => 'App\\Http\\Controllers\\ServicePlanningController@reorderWorshipPlan',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'services.reorder-worship-plan',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'services.volunteers' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'services/{service}/volunteers',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServicePlanningController@manageVolunteers',
        'controller' => 'App\\Http\\Controllers\\ServicePlanningController@manageVolunteers',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'services.volunteers',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'services.assign-volunteer' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'services/{service}/volunteers',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServicePlanningController@assignVolunteer',
        'controller' => 'App\\Http\\Controllers\\ServicePlanningController@assignVolunteer',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'services.assign-volunteer',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'services.update-volunteer' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'services/volunteers/{volunteer}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServicePlanningController@updateVolunteer',
        'controller' => 'App\\Http\\Controllers\\ServicePlanningController@updateVolunteer',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'services.update-volunteer',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'services.remove-volunteer' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'services/volunteers/{volunteer}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServicePlanningController@removeVolunteer',
        'controller' => 'App\\Http\\Controllers\\ServicePlanningController@removeVolunteer',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'services.remove-volunteer',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'services.confirm-volunteer' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'services/volunteers/{volunteer}/confirm',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ServicePlanningController@confirmVolunteer',
        'controller' => 'App\\Http\\Controllers\\ServicePlanningController@confirmVolunteer',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'services.confirm-volunteer',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'prayer.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'prayer',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\PrayerController@index',
        'controller' => 'App\\Http\\Controllers\\PrayerController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'prayer.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'prayer.analytics' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'prayer/analytics',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\PrayerController@analytics',
        'controller' => 'App\\Http\\Controllers\\PrayerController@analytics',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'prayer.analytics',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'prayer.assign' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'prayer/{prayerRequest}/assign',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\PrayerController@assign',
        'controller' => 'App\\Http\\Controllers\\PrayerController@assign',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'prayer.assign',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'prayer.add-update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'prayer/{prayerRequest}/add-update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\PrayerController@addUpdate',
        'controller' => 'App\\Http\\Controllers\\PrayerController@addUpdate',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'prayer.add-update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'prayer.mark-answered' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'prayer/{prayerRequest}/mark-answered',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\PrayerController@markAnswered',
        'controller' => 'App\\Http\\Controllers\\PrayerController@markAnswered',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'prayer.mark-answered',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'prayer.testimonies' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'prayer/testimonies',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\PrayerController@testimonies',
        'controller' => 'App\\Http\\Controllers\\PrayerController@testimonies',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'prayer.testimonies',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'prayer.approve-testimony' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'prayer/testimonies/{testimony}/approve',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\PrayerController@approveTestimony',
        'controller' => 'App\\Http\\Controllers\\PrayerController@approveTestimony',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'prayer.approve-testimony',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'prayer.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'prayer/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\PrayerController@create',
        'controller' => 'App\\Http\\Controllers\\PrayerController@create',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'prayer.create',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'prayer.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'prayer',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\PrayerController@store',
        'controller' => 'App\\Http\\Controllers\\PrayerController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'prayer.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'prayer.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'prayer/{prayerRequest}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\PrayerController@show',
        'controller' => 'App\\Http\\Controllers\\PrayerController@show',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'prayer.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'prayer.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'prayer/{prayerRequest}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\PrayerController@edit',
        'controller' => 'App\\Http\\Controllers\\PrayerController@edit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'prayer.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'prayer.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'prayer/{prayerRequest}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\PrayerController@update',
        'controller' => 'App\\Http\\Controllers\\PrayerController@update',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'prayer.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'prayer.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'prayer/{prayerRequest}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\PrayerController@destroy',
        'controller' => 'App\\Http\\Controllers\\PrayerController@destroy',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'prayer.destroy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'prayer.wall' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'prayer/wall',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\PrayerController@prayerWall',
        'controller' => 'App\\Http\\Controllers\\PrayerController@prayerWall',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'prayer.wall',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'prayer.my-requests' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'prayer/my-requests',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\PrayerController@myRequests',
        'controller' => 'App\\Http\\Controllers\\PrayerController@myRequests',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'prayer.my-requests',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'prayer.my-assignments' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'prayer/my-assignments',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\PrayerController@myAssignments',
        'controller' => 'App\\Http\\Controllers\\PrayerController@myAssignments',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'prayer.my-assignments',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'prayer.testimonies-wall' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'prayer/testimonies/wall',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\PrayerController@testimoniesWall',
        'controller' => 'App\\Http\\Controllers\\PrayerController@testimoniesWall',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'prayer.testimonies-wall',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'birthdays.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'birthdays',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\BirthdayController@index',
        'controller' => 'App\\Http\\Controllers\\BirthdayController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'birthdays.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'birthdays.calendar' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'birthdays/calendar',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\BirthdayController@calendar',
        'controller' => 'App\\Http\\Controllers\\BirthdayController@calendar',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'birthdays.calendar',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'birthdays.history' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'birthdays/history',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\BirthdayController@history',
        'controller' => 'App\\Http\\Controllers\\BirthdayController@history',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'birthdays.history',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'birthdays.milestones' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'birthdays/milestones',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\BirthdayController@milestones',
        'controller' => 'App\\Http\\Controllers\\BirthdayController@milestones',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'birthdays.milestones',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'birthdays.announcements' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'birthdays/announcements',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\BirthdayController@announcements',
        'controller' => 'App\\Http\\Controllers\\BirthdayController@announcements',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'birthdays.announcements',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'birthdays.recognize-milestone' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'birthdays/milestones/{milestone}/recognize',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\BirthdayController@recognizeMilestone',
        'controller' => 'App\\Http\\Controllers\\BirthdayController@recognizeMilestone',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'birthdays.recognize-milestone',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'birthdays.mark-announcement-displayed' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'birthdays/announcements/{announcement}/display',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\BirthdayController@markAnnouncementDisplayed',
        'controller' => 'App\\Http\\Controllers\\BirthdayController@markAnnouncementDisplayed',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'birthdays.mark-announcement-displayed',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'birthdays.settings' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'birthdays/settings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
          3 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\BirthdayController@settings',
        'controller' => 'App\\Http\\Controllers\\BirthdayController@settings',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'birthdays.settings',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'birthdays.update-settings' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'birthdays/settings/{eventType}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
          3 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\BirthdayController@updateSettings',
        'controller' => 'App\\Http\\Controllers\\BirthdayController@updateSettings',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'birthdays.update-settings',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'birthdays.process' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'birthdays/process',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
          3 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\BirthdayController@processBirthdays',
        'controller' => 'App\\Http\\Controllers\\BirthdayController@processBirthdays',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'birthdays.process',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'birthdays.retry-failed' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'birthdays/retry-failed',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
          3 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\BirthdayController@retryFailed',
        'controller' => 'App\\Http\\Controllers\\BirthdayController@retryFailed',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'birthdays.retry-failed',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reports.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'reports',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@index',
        'controller' => 'App\\Http\\Controllers\\ReportController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reports.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reports.builder' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'reports/builder',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@builder',
        'controller' => 'App\\Http\\Controllers\\ReportController@builder',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reports.builder',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reports.custom.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'reports/custom',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@storeCustomReport',
        'controller' => 'App\\Http\\Controllers\\ReportController@storeCustomReport',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reports.custom.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reports.custom.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'reports/custom/{report}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@showCustomReport',
        'controller' => 'App\\Http\\Controllers\\ReportController@showCustomReport',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reports.custom.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reports.custom.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'reports/custom/{report}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@editCustomReport',
        'controller' => 'App\\Http\\Controllers\\ReportController@editCustomReport',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reports.custom.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reports.custom.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'reports/custom/{report}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@updateCustomReport',
        'controller' => 'App\\Http\\Controllers\\ReportController@updateCustomReport',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reports.custom.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reports.custom.delete' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'reports/custom/{report}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@deleteCustomReport',
        'controller' => 'App\\Http\\Controllers\\ReportController@deleteCustomReport',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reports.custom.delete',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reports.custom.duplicate' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'reports/custom/{report}/duplicate',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@duplicateCustomReport',
        'controller' => 'App\\Http\\Controllers\\ReportController@duplicateCustomReport',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reports.custom.duplicate',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reports.custom.favorite' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'reports/custom/{report}/favorite',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@toggleFavorite',
        'controller' => 'App\\Http\\Controllers\\ReportController@toggleFavorite',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reports.custom.favorite',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reports.membership.roster' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'reports/membership',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@membershipReports',
        'controller' => 'App\\Http\\Controllers\\ReportController@membershipReports',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reports.membership.roster',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reports.membership.new' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'reports/membership/new',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@membershipReports',
        'controller' => 'App\\Http\\Controllers\\ReportController@membershipReports',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reports.membership.new',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reports.membership.demographics' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'reports/membership/demographics',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@membershipReports',
        'controller' => 'App\\Http\\Controllers\\ReportController@membershipReports',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reports.membership.demographics',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reports.membership.birthdays' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'reports/membership/birthdays',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@membershipReports',
        'controller' => 'App\\Http\\Controllers\\ReportController@membershipReports',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reports.membership.birthdays',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reports.financial.income' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'reports/financial',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@financialReports',
        'controller' => 'App\\Http\\Controllers\\ReportController@financialReports',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reports.financial.income',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reports.financial.expenses' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'reports/financial/expenses',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@financialReports',
        'controller' => 'App\\Http\\Controllers\\ReportController@financialReports',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reports.financial.expenses',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reports.financial.cash-flow' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'reports/financial/cash-flow',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@financialReports',
        'controller' => 'App\\Http\\Controllers\\ReportController@financialReports',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reports.financial.cash-flow',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reports.financial.giving' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'reports/financial/giving',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@financialReports',
        'controller' => 'App\\Http\\Controllers\\ReportController@financialReports',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reports.financial.giving',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reports.attendance.summary' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'reports/attendance',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@attendanceReports',
        'controller' => 'App\\Http\\Controllers\\ReportController@attendanceReports',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reports.attendance.summary',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reports.attendance.trends' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'reports/attendance/trends',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@attendanceReports',
        'controller' => 'App\\Http\\Controllers\\ReportController@attendanceReports',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reports.attendance.trends',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reports.attendance.absentees' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'reports/attendance/absentees',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@attendanceReports',
        'controller' => 'App\\Http\\Controllers\\ReportController@attendanceReports',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reports.attendance.absentees',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reports.program.performance' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'reports/program',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@programReports',
        'controller' => 'App\\Http\\Controllers\\ReportController@programReports',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reports.program.performance',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reports.program.impact' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'reports/program/impact',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@programReports',
        'controller' => 'App\\Http\\Controllers\\ReportController@programReports',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reports.program.impact',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reports.analytics' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'reports/analytics',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@analytics',
        'controller' => 'App\\Http\\Controllers\\ReportController@analytics',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reports.analytics',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reports.schedules' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'reports/schedules',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@schedules',
        'controller' => 'App\\Http\\Controllers\\ReportController@schedules',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reports.schedules',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reports.schedules.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'reports/schedules',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@storeSchedule',
        'controller' => 'App\\Http\\Controllers\\ReportController@storeSchedule',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reports.schedules.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reports.schedules.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'reports/schedules/{schedule}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@updateSchedule',
        'controller' => 'App\\Http\\Controllers\\ReportController@updateSchedule',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reports.schedules.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reports.schedules.delete' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'reports/schedules/{schedule}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@deleteSchedule',
        'controller' => 'App\\Http\\Controllers\\ReportController@deleteSchedule',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reports.schedules.delete',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reports.executions' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'reports/executions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@executions',
        'controller' => 'App\\Http\\Controllers\\ReportController@executions',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reports.executions',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reports.executions.download' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'reports/executions/{execution}/download',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@downloadExecution',
        'controller' => 'App\\Http\\Controllers\\ReportController@downloadExecution',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reports.executions.download',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reports.executions.delete' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'reports/executions/{execution}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@deleteExecution',
        'controller' => 'App\\Http\\Controllers\\ReportController@deleteExecution',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reports.executions.delete',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reports.export.pdf' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'reports/export/pdf',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@exportPdf',
        'controller' => 'App\\Http\\Controllers\\ReportController@exportPdf',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reports.export.pdf',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reports.export.excel' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'reports/export/excel',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@exportExcel',
        'controller' => 'App\\Http\\Controllers\\ReportController@exportExcel',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reports.export.excel',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reports.export.csv' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'reports/export/csv',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ReportController@exportCsv',
        'controller' => 'App\\Http\\Controllers\\ReportController@exportCsv',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reports.export.csv',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'childrens-ministry.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'childrens-ministry',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ChildrensMinistryController@index',
        'controller' => 'App\\Http\\Controllers\\ChildrensMinistryController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'childrens-ministry.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'childrens-ministry.children' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'childrens-ministry/children',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ChildrensMinistryController@children',
        'controller' => 'App\\Http\\Controllers\\ChildrensMinistryController@children',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'childrens-ministry.children',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'childrens-ministry.children.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'childrens-ministry/children/{child}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ChildrensMinistryController@showChild',
        'controller' => 'App\\Http\\Controllers\\ChildrensMinistryController@showChild',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'childrens-ministry.children.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'childrens-ministry.checkin' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'childrens-ministry/checkin',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ChildrensMinistryController@checkinInterface',
        'controller' => 'App\\Http\\Controllers\\ChildrensMinistryController@checkinInterface',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'childrens-ministry.checkin',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'childrens-ministry.checkin.process' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'childrens-ministry/checkin',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ChildrensMinistryController@processCheckin',
        'controller' => 'App\\Http\\Controllers\\ChildrensMinistryController@processCheckin',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'childrens-ministry.checkin.process',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'childrens-ministry.checkout.process' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'childrens-ministry/checkout/{checkin}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ChildrensMinistryController@processCheckout',
        'controller' => 'App\\Http\\Controllers\\ChildrensMinistryController@processCheckout',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'childrens-ministry.checkout.process',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'childrens-ministry.curriculum' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'childrens-ministry/curriculum',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ChildrensMinistryController@curriculumLessons',
        'controller' => 'App\\Http\\Controllers\\ChildrensMinistryController@curriculumLessons',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'childrens-ministry.curriculum',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'childrens-ministry.curriculum.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'childrens-ministry/curriculum/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ChildrensMinistryController@createLesson',
        'controller' => 'App\\Http\\Controllers\\ChildrensMinistryController@createLesson',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'childrens-ministry.curriculum.create',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'childrens-ministry.curriculum.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'childrens-ministry/curriculum',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ChildrensMinistryController@storeLesson',
        'controller' => 'App\\Http\\Controllers\\ChildrensMinistryController@storeLesson',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'childrens-ministry.curriculum.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'childrens-ministry.curriculum.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'childrens-ministry/curriculum/{lesson}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ChildrensMinistryController@showLesson',
        'controller' => 'App\\Http\\Controllers\\ChildrensMinistryController@showLesson',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'childrens-ministry.curriculum.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'childrens-ministry.curriculum.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'childrens-ministry/curriculum/{lesson}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ChildrensMinistryController@editLesson',
        'controller' => 'App\\Http\\Controllers\\ChildrensMinistryController@editLesson',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'childrens-ministry.curriculum.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'childrens-ministry.curriculum.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'childrens-ministry/curriculum/{lesson}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ChildrensMinistryController@updateLesson',
        'controller' => 'App\\Http\\Controllers\\ChildrensMinistryController@updateLesson',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'childrens-ministry.curriculum.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'childrens-ministry.curriculum.delete' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'childrens-ministry/curriculum/{lesson}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ChildrensMinistryController@deleteLesson',
        'controller' => 'App\\Http\\Controllers\\ChildrensMinistryController@deleteLesson',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'childrens-ministry.curriculum.delete',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'childrens-ministry.curriculum.publish' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'childrens-ministry/curriculum/{lesson}/publish',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ChildrensMinistryController@publishLesson',
        'controller' => 'App\\Http\\Controllers\\ChildrensMinistryController@publishLesson',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'childrens-ministry.curriculum.publish',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'childrens-ministry.events' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'childrens-ministry/events',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ChildrensMinistryController@events',
        'controller' => 'App\\Http\\Controllers\\ChildrensMinistryController@events',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'childrens-ministry.events',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'childrens-ministry.events.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'childrens-ministry/events/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ChildrensMinistryController@createEvent',
        'controller' => 'App\\Http\\Controllers\\ChildrensMinistryController@createEvent',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'childrens-ministry.events.create',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'childrens-ministry.events.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'childrens-ministry/events',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ChildrensMinistryController@storeEvent',
        'controller' => 'App\\Http\\Controllers\\ChildrensMinistryController@storeEvent',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'childrens-ministry.events.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'childrens-ministry.events.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'childrens-ministry/events/{event}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ChildrensMinistryController@showEvent',
        'controller' => 'App\\Http\\Controllers\\ChildrensMinistryController@showEvent',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'childrens-ministry.events.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'childrens-ministry.events.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'childrens-ministry/events/{event}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ChildrensMinistryController@updateEvent',
        'controller' => 'App\\Http\\Controllers\\ChildrensMinistryController@updateEvent',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'childrens-ministry.events.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'childrens-ministry.events.register' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'childrens-ministry/events/{event}/register',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ChildrensMinistryController@registerForEvent',
        'controller' => 'App\\Http\\Controllers\\ChildrensMinistryController@registerForEvent',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'childrens-ministry.events.register',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'childrens-ministry.events.publish' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'childrens-ministry/events/{event}/publish',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ChildrensMinistryController@publishEvent',
        'controller' => 'App\\Http\\Controllers\\ChildrensMinistryController@publishEvent',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'childrens-ministry.events.publish',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'childrens-ministry.events.start' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'childrens-ministry/events/{event}/start',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ChildrensMinistryController@startEvent',
        'controller' => 'App\\Http\\Controllers\\ChildrensMinistryController@startEvent',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'childrens-ministry.events.start',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'childrens-ministry.events.complete' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'childrens-ministry/events/{event}/complete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ChildrensMinistryController@completeEvent',
        'controller' => 'App\\Http\\Controllers\\ChildrensMinistryController@completeEvent',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'childrens-ministry.events.complete',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'childrens-ministry.reports' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'childrens-ministry/reports',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\ChildrensMinistryController@reports',
        'controller' => 'App\\Http\\Controllers\\ChildrensMinistryController@reports',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'childrens-ministry.reports',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'settings.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'settings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\SettingsController@index',
        'controller' => 'App\\Http\\Controllers\\SettingsController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'settings.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'settings.update-general' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'settings/general',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\SettingsController@updateGeneral',
        'controller' => 'App\\Http\\Controllers\\SettingsController@updateGeneral',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'settings.update-general',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'settings.email-templates' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'settings/email-templates',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\SettingsController@emailTemplates',
        'controller' => 'App\\Http\\Controllers\\SettingsController@emailTemplates',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'settings.email-templates',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'settings.edit-email-template' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'settings/email-templates/{template}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\SettingsController@editEmailTemplate',
        'controller' => 'App\\Http\\Controllers\\SettingsController@editEmailTemplate',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'settings.edit-email-template',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'settings.update-email-template' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'settings/email-templates/{template}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\SettingsController@updateEmailTemplate',
        'controller' => 'App\\Http\\Controllers\\SettingsController@updateEmailTemplate',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'settings.update-email-template',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'settings.audit-logs' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'settings/audit-logs',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\SettingsController@auditLogs',
        'controller' => 'App\\Http\\Controllers\\SettingsController@auditLogs',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'settings.audit-logs',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'settings.backups' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'settings/backups',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\SettingsController@backups',
        'controller' => 'App\\Http\\Controllers\\SettingsController@backups',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'settings.backups',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'settings.create-backup' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'settings/backups',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\SettingsController@createBackup',
        'controller' => 'App\\Http\\Controllers\\SettingsController@createBackup',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'settings.create-backup',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'settings.download-backup' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'settings/backups/{backup}/download',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\SettingsController@downloadBackup',
        'controller' => 'App\\Http\\Controllers\\SettingsController@downloadBackup',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'settings.download-backup',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'settings.delete-backup' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'settings/backups/{backup}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\SettingsController@deleteBackup',
        'controller' => 'App\\Http\\Controllers\\SettingsController@deleteBackup',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'settings.delete-backup',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'settings.system-info' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'settings/system-info',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\SettingsController@systemInfo',
        'controller' => 'App\\Http\\Controllers\\SettingsController@systemInfo',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'settings.system-info',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'settings.clear-cache' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'settings/clear-cache',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\SettingsController@clearCache',
        'controller' => 'App\\Http\\Controllers\\SettingsController@clearCache',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'settings.clear-cache',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'counselling.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'counselling',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\CounsellingController@index',
        'controller' => 'App\\Http\\Controllers\\CounsellingController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'counselling.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'counselling.counsellors' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'counselling/counsellors',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\CounsellingController@counsellors',
        'controller' => 'App\\Http\\Controllers\\CounsellingController@counsellors',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'counselling.counsellors',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'counselling.counsellors.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'counselling/counsellors/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\CounsellingController@createCounsellor',
        'controller' => 'App\\Http\\Controllers\\CounsellingController@createCounsellor',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'counselling.counsellors.create',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'counselling.counsellors.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'counselling/counsellors',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\CounsellingController@storeCounsellor',
        'controller' => 'App\\Http\\Controllers\\CounsellingController@storeCounsellor',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'counselling.counsellors.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'counselling.counsellors.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'counselling/counsellors/{counsellor}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\CounsellingController@showCounsellor',
        'controller' => 'App\\Http\\Controllers\\CounsellingController@showCounsellor',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'counselling.counsellors.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'counselling.counsellors.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'counselling/counsellors/{counsellor}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\CounsellingController@updateCounsellor',
        'controller' => 'App\\Http\\Controllers\\CounsellingController@updateCounsellor',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'counselling.counsellors.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'counselling.counsellors.activate' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'counselling/counsellors/{counsellor}/activate',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\CounsellingController@activateCounsellor',
        'controller' => 'App\\Http\\Controllers\\CounsellingController@activateCounsellor',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'counselling.counsellors.activate',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'counselling.counsellors.deactivate' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'counselling/counsellors/{counsellor}/deactivate',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\CounsellingController@deactivateCounsellor',
        'controller' => 'App\\Http\\Controllers\\CounsellingController@deactivateCounsellor',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'counselling.counsellors.deactivate',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'counselling.sessions' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'counselling/sessions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\CounsellingController@sessions',
        'controller' => 'App\\Http\\Controllers\\CounsellingController@sessions',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'counselling.sessions',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'counselling.sessions.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'counselling/sessions/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\CounsellingController@createSession',
        'controller' => 'App\\Http\\Controllers\\CounsellingController@createSession',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'counselling.sessions.create',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'counselling.sessions.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'counselling/sessions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\CounsellingController@storeSession',
        'controller' => 'App\\Http\\Controllers\\CounsellingController@storeSession',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'counselling.sessions.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'counselling.sessions.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'counselling/sessions/{session}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\CounsellingController@showSession',
        'controller' => 'App\\Http\\Controllers\\CounsellingController@showSession',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'counselling.sessions.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'counselling.sessions.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'counselling/sessions/{session}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\CounsellingController@updateSession',
        'controller' => 'App\\Http\\Controllers\\CounsellingController@updateSession',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'counselling.sessions.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'counselling.sessions.confirm' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'counselling/sessions/{session}/confirm',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\CounsellingController@confirmSession',
        'controller' => 'App\\Http\\Controllers\\CounsellingController@confirmSession',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'counselling.sessions.confirm',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'counselling.sessions.start' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'counselling/sessions/{session}/start',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\CounsellingController@startSession',
        'controller' => 'App\\Http\\Controllers\\CounsellingController@startSession',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'counselling.sessions.start',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'counselling.sessions.complete' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'counselling/sessions/{session}/complete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\CounsellingController@completeSession',
        'controller' => 'App\\Http\\Controllers\\CounsellingController@completeSession',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'counselling.sessions.complete',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'counselling.sessions.cancel' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'counselling/sessions/{session}/cancel',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\CounsellingController@cancelSession',
        'controller' => 'App\\Http\\Controllers\\CounsellingController@cancelSession',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'counselling.sessions.cancel',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'counselling.sessions.reschedule' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'counselling/sessions/{session}/reschedule',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\CounsellingController@rescheduleSession',
        'controller' => 'App\\Http\\Controllers\\CounsellingController@rescheduleSession',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'counselling.sessions.reschedule',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'counselling.available-counsellors' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'counselling/available-counsellors',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\CounsellingController@getAvailableCounsellors',
        'controller' => 'App\\Http\\Controllers\\CounsellingController@getAvailableCounsellors',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'counselling.available-counsellors',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'counselling.cases' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'counselling/cases',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\CounsellingController@cases',
        'controller' => 'App\\Http\\Controllers\\CounsellingController@cases',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'counselling.cases',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'counselling.cases.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'counselling/cases/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\CounsellingController@createCase',
        'controller' => 'App\\Http\\Controllers\\CounsellingController@createCase',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'counselling.cases.create',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'counselling.cases.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'counselling/cases',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\CounsellingController@storeCase',
        'controller' => 'App\\Http\\Controllers\\CounsellingController@storeCase',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'counselling.cases.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'counselling.cases.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'counselling/cases/{case}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\CounsellingController@showCase',
        'controller' => 'App\\Http\\Controllers\\CounsellingController@showCase',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'counselling.cases.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'counselling.cases.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'counselling/cases/{case}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\CounsellingController@updateCase',
        'controller' => 'App\\Http\\Controllers\\CounsellingController@updateCase',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'counselling.cases.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'counselling.cases.activate' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'counselling/cases/{case}/activate',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\CounsellingController@activateCase',
        'controller' => 'App\\Http\\Controllers\\CounsellingController@activateCase',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'counselling.cases.activate',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'counselling.cases.hold' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'counselling/cases/{case}/hold',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\CounsellingController@holdCase',
        'controller' => 'App\\Http\\Controllers\\CounsellingController@holdCase',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'counselling.cases.hold',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'counselling.cases.close' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'counselling/cases/{case}/close',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\CounsellingController@closeCase',
        'controller' => 'App\\Http\\Controllers\\CounsellingController@closeCase',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'counselling.cases.close',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'counselling.resources' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'counselling/resources',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\CounsellingController@resources',
        'controller' => 'App\\Http\\Controllers\\CounsellingController@resources',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'counselling.resources',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'counselling.resources.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'counselling/resources/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\CounsellingController@createResource',
        'controller' => 'App\\Http\\Controllers\\CounsellingController@createResource',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'counselling.resources.create',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'counselling.resources.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'counselling/resources',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\CounsellingController@storeResource',
        'controller' => 'App\\Http\\Controllers\\CounsellingController@storeResource',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'counselling.resources.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'counselling.resources.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'counselling/resources/{resource}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\CounsellingController@showResource',
        'controller' => 'App\\Http\\Controllers\\CounsellingController@showResource',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'counselling.resources.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'counselling.resources.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'counselling/resources/{resource}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\CounsellingController@updateResource',
        'controller' => 'App\\Http\\Controllers\\CounsellingController@updateResource',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'counselling.resources.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'counselling.resources.download' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'counselling/resources/{resource}/download',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\CounsellingController@downloadResource',
        'controller' => 'App\\Http\\Controllers\\CounsellingController@downloadResource',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'counselling.resources.download',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'counselling.reports' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'counselling/reports',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\CounsellingController@reports',
        'controller' => 'App\\Http\\Controllers\\CounsellingController@reports',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'counselling.reports',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'welfare.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'welfare',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\WelfareController@index',
        'controller' => 'App\\Http\\Controllers\\WelfareController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'welfare.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'welfare.cases' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'welfare/cases',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\WelfareController@cases',
        'controller' => 'App\\Http\\Controllers\\WelfareController@cases',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'welfare.cases',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'welfare.cases.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'welfare/cases/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\WelfareController@createCase',
        'controller' => 'App\\Http\\Controllers\\WelfareController@createCase',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'welfare.cases.create',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'welfare.cases.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'welfare/cases',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\WelfareController@storeCase',
        'controller' => 'App\\Http\\Controllers\\WelfareController@storeCase',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'welfare.cases.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'welfare.cases.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'welfare/cases/{case}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\WelfareController@showCase',
        'controller' => 'App\\Http\\Controllers\\WelfareController@showCase',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'welfare.cases.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'welfare.cases.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'welfare/cases/{case}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\WelfareController@updateCase',
        'controller' => 'App\\Http\\Controllers\\WelfareController@updateCase',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'welfare.cases.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'welfare.cases.under-review' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'welfare/cases/{case}/under-review',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\WelfareController@markUnderReview',
        'controller' => 'App\\Http\\Controllers\\WelfareController@markUnderReview',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'welfare.cases.under-review',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'welfare.cases.verify' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'welfare/cases/{case}/verify',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\WelfareController@verifyCase',
        'controller' => 'App\\Http\\Controllers\\WelfareController@verifyCase',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'welfare.cases.verify',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'welfare.cases.reject-verification' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'welfare/cases/{case}/reject-verification',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\WelfareController@rejectVerification',
        'controller' => 'App\\Http\\Controllers\\WelfareController@rejectVerification',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'welfare.cases.reject-verification',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'welfare.cases.approve' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'welfare/cases/{case}/approve',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\WelfareController@approveCase',
        'controller' => 'App\\Http\\Controllers\\WelfareController@approveCase',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'welfare.cases.approve',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'welfare.cases.reject' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'welfare/cases/{case}/reject',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\WelfareController@rejectCase',
        'controller' => 'App\\Http\\Controllers\\WelfareController@rejectCase',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'welfare.cases.reject',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'welfare.cases.close' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'welfare/cases/{case}/close',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\WelfareController@closeCase',
        'controller' => 'App\\Http\\Controllers\\WelfareController@closeCase',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'welfare.cases.close',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'welfare.programs' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'welfare/programs',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\WelfareController@programs',
        'controller' => 'App\\Http\\Controllers\\WelfareController@programs',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'welfare.programs',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'welfare.programs.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'welfare/programs/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\WelfareController@createProgram',
        'controller' => 'App\\Http\\Controllers\\WelfareController@createProgram',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'welfare.programs.create',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'welfare.programs.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'welfare/programs',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\WelfareController@storeProgram',
        'controller' => 'App\\Http\\Controllers\\WelfareController@storeProgram',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'welfare.programs.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'welfare.programs.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'welfare/programs/{program}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\WelfareController@showProgram',
        'controller' => 'App\\Http\\Controllers\\WelfareController@showProgram',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'welfare.programs.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'welfare.programs.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'welfare/programs/{program}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\WelfareController@updateProgram',
        'controller' => 'App\\Http\\Controllers\\WelfareController@updateProgram',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'welfare.programs.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'welfare.programs.activate' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'welfare/programs/{program}/activate',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\WelfareController@activateProgram',
        'controller' => 'App\\Http\\Controllers\\WelfareController@activateProgram',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'welfare.programs.activate',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'welfare.programs.pause' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'welfare/programs/{program}/pause',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\WelfareController@pauseProgram',
        'controller' => 'App\\Http\\Controllers\\WelfareController@pauseProgram',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'welfare.programs.pause',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'welfare.programs.complete' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'welfare/programs/{program}/complete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\WelfareController@completeProgram',
        'controller' => 'App\\Http\\Controllers\\WelfareController@completeProgram',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'welfare.programs.complete',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'welfare.fund-transactions' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'welfare/fund-transactions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\WelfareController@fundTransactions',
        'controller' => 'App\\Http\\Controllers\\WelfareController@fundTransactions',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'welfare.fund-transactions',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'welfare.record-transaction' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'welfare/fund-transactions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\WelfareController@recordTransaction',
        'controller' => 'App\\Http\\Controllers\\WelfareController@recordTransaction',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'welfare.record-transaction',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'welfare.reports' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'welfare/reports',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\WelfareController@reports',
        'controller' => 'App\\Http\\Controllers\\WelfareController@reports',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'welfare.reports',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'messaging.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'messaging',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@index',
        'controller' => 'App\\Http\\Controllers\\MessagingController@index',
        'as' => 'messaging.index',
        'namespace' => NULL,
        'prefix' => '/messaging',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'messaging.conversation' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'messaging/conversations/{conversation}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@showConversation',
        'controller' => 'App\\Http\\Controllers\\MessagingController@showConversation',
        'as' => 'messaging.conversation',
        'namespace' => NULL,
        'prefix' => '/messaging',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'messaging.conversation.messages' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'messaging/conversations/{conversation}/messages',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@getMessages',
        'controller' => 'App\\Http\\Controllers\\MessagingController@getMessages',
        'as' => 'messaging.conversation.messages',
        'namespace' => NULL,
        'prefix' => '/messaging',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'messaging.conversation.mark-read' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'messaging/conversations/{conversation}/mark-read',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@markAsRead',
        'controller' => 'App\\Http\\Controllers\\MessagingController@markAsRead',
        'as' => 'messaging.conversation.mark-read',
        'namespace' => NULL,
        'prefix' => '/messaging',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'messaging.conversation.archive' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'messaging/conversations/{conversation}/archive',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@archiveConversation',
        'controller' => 'App\\Http\\Controllers\\MessagingController@archiveConversation',
        'as' => 'messaging.conversation.archive',
        'namespace' => NULL,
        'prefix' => '/messaging',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'messaging.conversation.unarchive' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'messaging/conversations/{conversation}/unarchive',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@unarchiveConversation',
        'controller' => 'App\\Http\\Controllers\\MessagingController@unarchiveConversation',
        'as' => 'messaging.conversation.unarchive',
        'namespace' => NULL,
        'prefix' => '/messaging',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'messaging.direct' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'messaging/direct',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@startDirectConversation',
        'controller' => 'App\\Http\\Controllers\\MessagingController@startDirectConversation',
        'as' => 'messaging.direct',
        'namespace' => NULL,
        'prefix' => '/messaging',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'messaging.groups.create' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'messaging/groups',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@createGroup',
        'controller' => 'App\\Http\\Controllers\\MessagingController@createGroup',
        'as' => 'messaging.groups.create',
        'namespace' => NULL,
        'prefix' => '/messaging',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'messaging.groups.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'messaging/groups/{conversation}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@updateGroup',
        'controller' => 'App\\Http\\Controllers\\MessagingController@updateGroup',
        'as' => 'messaging.groups.update',
        'namespace' => NULL,
        'prefix' => '/messaging',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'messaging.groups.add-participants' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'messaging/groups/{conversation}/participants',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@addParticipants',
        'controller' => 'App\\Http\\Controllers\\MessagingController@addParticipants',
        'as' => 'messaging.groups.add-participants',
        'namespace' => NULL,
        'prefix' => '/messaging',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'messaging.groups.remove-participant' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'messaging/groups/{conversation}/participants',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@removeParticipant',
        'controller' => 'App\\Http\\Controllers\\MessagingController@removeParticipant',
        'as' => 'messaging.groups.remove-participant',
        'namespace' => NULL,
        'prefix' => '/messaging',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'messaging.groups.leave' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'messaging/groups/{conversation}/leave',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@leaveGroup',
        'controller' => 'App\\Http\\Controllers\\MessagingController@leaveGroup',
        'as' => 'messaging.groups.leave',
        'namespace' => NULL,
        'prefix' => '/messaging',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'messaging.messages.send' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'messaging/conversations/{conversation}/messages',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@sendMessage',
        'controller' => 'App\\Http\\Controllers\\MessagingController@sendMessage',
        'as' => 'messaging.messages.send',
        'namespace' => NULL,
        'prefix' => '/messaging',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'messaging.messages.edit' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'messaging/messages/{message}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@editMessage',
        'controller' => 'App\\Http\\Controllers\\MessagingController@editMessage',
        'as' => 'messaging.messages.edit',
        'namespace' => NULL,
        'prefix' => '/messaging',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'messaging.messages.delete' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'messaging/messages/{message}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@deleteMessage',
        'controller' => 'App\\Http\\Controllers\\MessagingController@deleteMessage',
        'as' => 'messaging.messages.delete',
        'namespace' => NULL,
        'prefix' => '/messaging',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'messaging.messages.pin' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'messaging/messages/{message}/pin',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@pinMessage',
        'controller' => 'App\\Http\\Controllers\\MessagingController@pinMessage',
        'as' => 'messaging.messages.pin',
        'namespace' => NULL,
        'prefix' => '/messaging',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'messaging.messages.unpin' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'messaging/messages/{message}/pin',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@unpinMessage',
        'controller' => 'App\\Http\\Controllers\\MessagingController@unpinMessage',
        'as' => 'messaging.messages.unpin',
        'namespace' => NULL,
        'prefix' => '/messaging',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'messaging.messages.react' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'messaging/messages/{message}/reactions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@reactToMessage',
        'controller' => 'App\\Http\\Controllers\\MessagingController@reactToMessage',
        'as' => 'messaging.messages.react',
        'namespace' => NULL,
        'prefix' => '/messaging',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'messaging.messages.unreact' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'messaging/messages/{message}/reactions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@removeReaction',
        'controller' => 'App\\Http\\Controllers\\MessagingController@removeReaction',
        'as' => 'messaging.messages.unreact',
        'namespace' => NULL,
        'prefix' => '/messaging',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'messaging.messages.star' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'messaging/messages/{message}/star',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@starMessage',
        'controller' => 'App\\Http\\Controllers\\MessagingController@starMessage',
        'as' => 'messaging.messages.star',
        'namespace' => NULL,
        'prefix' => '/messaging',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'messaging.messages.unstar' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'messaging/messages/{message}/star',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@unstarMessage',
        'controller' => 'App\\Http\\Controllers\\MessagingController@unstarMessage',
        'as' => 'messaging.messages.unstar',
        'namespace' => NULL,
        'prefix' => '/messaging',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'messaging.starred' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'messaging/starred',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@starredMessages',
        'controller' => 'App\\Http\\Controllers\\MessagingController@starredMessages',
        'as' => 'messaging.starred',
        'namespace' => NULL,
        'prefix' => '/messaging',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'messaging.search' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'messaging/search',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@search',
        'controller' => 'App\\Http\\Controllers\\MessagingController@search',
        'as' => 'messaging.search',
        'namespace' => NULL,
        'prefix' => '/messaging',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'messaging.block' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'messaging/block',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@blockUser',
        'controller' => 'App\\Http\\Controllers\\MessagingController@blockUser',
        'as' => 'messaging.block',
        'namespace' => NULL,
        'prefix' => '/messaging',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'messaging.unblock' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'messaging/unblock',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@unblockUser',
        'controller' => 'App\\Http\\Controllers\\MessagingController@unblockUser',
        'as' => 'messaging.unblock',
        'namespace' => NULL,
        'prefix' => '/messaging',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'messaging.blocked' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'messaging/blocked',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@blockedUsers',
        'controller' => 'App\\Http\\Controllers\\MessagingController@blockedUsers',
        'as' => 'messaging.blocked',
        'namespace' => NULL,
        'prefix' => '/messaging',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'messaging.messages.report' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'messaging/messages/{message}/report',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\MessagingController@reportMessage',
        'controller' => 'App\\Http\\Controllers\\MessagingController@reportMessage',
        'as' => 'messaging.messages.report',
        'namespace' => NULL,
        'prefix' => '/messaging',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'media.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'media',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\MediaController@index',
        'controller' => 'App\\Http\\Controllers\\MediaController@index',
        'as' => 'media.index',
        'namespace' => NULL,
        'prefix' => '/media',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'media.content' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'media/content',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\MediaController@content',
        'controller' => 'App\\Http\\Controllers\\MediaController@content',
        'as' => 'media.content',
        'namespace' => NULL,
        'prefix' => '/media',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'media.content.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'media/content',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\MediaController@storeContent',
        'controller' => 'App\\Http\\Controllers\\MediaController@storeContent',
        'as' => 'media.content.store',
        'namespace' => NULL,
        'prefix' => '/media',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'media.content.publish' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'media/content/{content}/publish',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\MediaController@publishContent',
        'controller' => 'App\\Http\\Controllers\\MediaController@publishContent',
        'as' => 'media.content.publish',
        'namespace' => NULL,
        'prefix' => '/media',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'media.streams' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'media/streams',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\MediaController@streams',
        'controller' => 'App\\Http\\Controllers\\MediaController@streams',
        'as' => 'media.streams',
        'namespace' => NULL,
        'prefix' => '/media',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'media.streams.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'media/streams',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\MediaController@storeStream',
        'controller' => 'App\\Http\\Controllers\\MediaController@storeStream',
        'as' => 'media.streams.store',
        'namespace' => NULL,
        'prefix' => '/media',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'media.team' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'media/team',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor,staff',
        ),
        'uses' => 'App\\Http\\Controllers\\MediaController@teamMembers',
        'controller' => 'App\\Http\\Controllers\\MediaController@teamMembers',
        'as' => 'media.team',
        'namespace' => NULL,
        'prefix' => '/media',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'partnerships.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'partnerships',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\PartnershipController@index',
        'controller' => 'App\\Http\\Controllers\\PartnershipController@index',
        'as' => 'partnerships.index',
        'namespace' => NULL,
        'prefix' => '/partnerships',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'partnerships.partners' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'partnerships/partners',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\PartnershipController@partners',
        'controller' => 'App\\Http\\Controllers\\PartnershipController@partners',
        'as' => 'partnerships.partners',
        'namespace' => NULL,
        'prefix' => '/partnerships',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'partnerships.partners.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'partnerships/partners',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\PartnershipController@storePartner',
        'controller' => 'App\\Http\\Controllers\\PartnershipController@storePartner',
        'as' => 'partnerships.partners.store',
        'namespace' => NULL,
        'prefix' => '/partnerships',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'partnerships.agreements' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'partnerships/agreements',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\PartnershipController@agreements',
        'controller' => 'App\\Http\\Controllers\\PartnershipController@agreements',
        'as' => 'partnerships.agreements',
        'namespace' => NULL,
        'prefix' => '/partnerships',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'partnerships.agreements.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'partnerships/agreements',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\PartnershipController@storeAgreement',
        'controller' => 'App\\Http\\Controllers\\PartnershipController@storeAgreement',
        'as' => 'partnerships.agreements.store',
        'namespace' => NULL,
        'prefix' => '/partnerships',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'partnerships.agreements.activate' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'partnerships/agreements/{agreement}/activate',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\PartnershipController@activateAgreement',
        'controller' => 'App\\Http\\Controllers\\PartnershipController@activateAgreement',
        'as' => 'partnerships.agreements.activate',
        'namespace' => NULL,
        'prefix' => '/partnerships',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qr-codes.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'qr-codes',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\QrCodeController@index',
        'controller' => 'App\\Http\\Controllers\\QrCodeController@index',
        'as' => 'qr-codes.index',
        'namespace' => NULL,
        'prefix' => '/qr-codes',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qr-codes.service' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'qr-codes/service',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\QrCodeController@serviceQrCode',
        'controller' => 'App\\Http\\Controllers\\QrCodeController@serviceQrCode',
        'as' => 'qr-codes.service',
        'namespace' => NULL,
        'prefix' => '/qr-codes',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qr-codes.member-registration' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'qr-codes/member-registration',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\QrCodeController@memberRegistration',
        'controller' => 'App\\Http\\Controllers\\QrCodeController@memberRegistration',
        'as' => 'qr-codes.member-registration',
        'namespace' => NULL,
        'prefix' => '/qr-codes',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qr-codes.visitor-registration' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'qr-codes/visitor-registration',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\QrCodeController@visitorRegistration',
        'controller' => 'App\\Http\\Controllers\\QrCodeController@visitorRegistration',
        'as' => 'qr-codes.visitor-registration',
        'namespace' => NULL,
        'prefix' => '/qr-codes',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qr-codes.payment' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'qr-codes/payment',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\QrCodeController@payment',
        'controller' => 'App\\Http\\Controllers\\QrCodeController@payment',
        'as' => 'qr-codes.payment',
        'namespace' => NULL,
        'prefix' => '/qr-codes',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qr-codes.personal' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'qr-codes/personal',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\QrCodeController@personal',
        'controller' => 'App\\Http\\Controllers\\QrCodeController@personal',
        'as' => 'qr-codes.personal',
        'namespace' => NULL,
        'prefix' => '/qr-codes',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qr-codes.equipment' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'qr-codes/equipment/{equipment}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\QrCodeController@equipment',
        'controller' => 'App\\Http\\Controllers\\QrCodeController@equipment',
        'as' => 'qr-codes.equipment',
        'namespace' => NULL,
        'prefix' => '/qr-codes',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qr-codes.program' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'qr-codes/program/{program}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\QrCodeController@programRegistration',
        'controller' => 'App\\Http\\Controllers\\QrCodeController@programRegistration',
        'as' => 'qr-codes.program',
        'namespace' => NULL,
        'prefix' => '/qr-codes',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qr-codes.bulk-download' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'qr-codes/bulk-download',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\QrCodeController@bulkDownload',
        'controller' => 'App\\Http\\Controllers\\QrCodeController@bulkDownload',
        'as' => 'qr-codes.bulk-download',
        'namespace' => NULL,
        'prefix' => '/qr-codes',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qr-management.dashboard' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'qr-management/dashboard',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\QRManagementController@dashboard',
        'controller' => 'App\\Http\\Controllers\\QRManagementController@dashboard',
        'as' => 'qr-management.dashboard',
        'namespace' => NULL,
        'prefix' => '/qr-management',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qr-management.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'qr-management',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\QRManagementController@index',
        'controller' => 'App\\Http\\Controllers\\QRManagementController@index',
        'as' => 'qr-management.index',
        'namespace' => NULL,
        'prefix' => '/qr-management',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qr-management.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'qr-management/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\QRManagementController@create',
        'controller' => 'App\\Http\\Controllers\\QRManagementController@create',
        'as' => 'qr-management.create',
        'namespace' => NULL,
        'prefix' => '/qr-management',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qr-management.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'qr-management',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\QRManagementController@store',
        'controller' => 'App\\Http\\Controllers\\QRManagementController@store',
        'as' => 'qr-management.store',
        'namespace' => NULL,
        'prefix' => '/qr-management',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qr-management.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'qr-management/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\QRManagementController@show',
        'controller' => 'App\\Http\\Controllers\\QRManagementController@show',
        'as' => 'qr-management.show',
        'namespace' => NULL,
        'prefix' => '/qr-management',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qr-management.revoke' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'qr-management/{id}/revoke',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\QRManagementController@revoke',
        'controller' => 'App\\Http\\Controllers\\QRManagementController@revoke',
        'as' => 'qr-management.revoke',
        'namespace' => NULL,
        'prefix' => '/qr-management',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qr-management.extend' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'qr-management/{id}/extend',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\QRManagementController@extend',
        'controller' => 'App\\Http\\Controllers\\QRManagementController@extend',
        'as' => 'qr-management.extend',
        'namespace' => NULL,
        'prefix' => '/qr-management',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qr-management.analytics' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'qr-management/analytics/overview',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\QRManagementController@analytics',
        'controller' => 'App\\Http\\Controllers\\QRManagementController@analytics',
        'as' => 'qr-management.analytics',
        'namespace' => NULL,
        'prefix' => '/qr-management',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qr-management.settings' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'qr-management/settings/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\QRManagementController@settings',
        'controller' => 'App\\Http\\Controllers\\QRManagementController@settings',
        'as' => 'qr-management.settings',
        'namespace' => NULL,
        'prefix' => '/qr-management',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qr-management.print' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'qr-management/print/preview',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\QRManagementController@printPreview',
        'controller' => 'App\\Http\\Controllers\\QRManagementController@printPreview',
        'as' => 'qr-management.print',
        'namespace' => NULL,
        'prefix' => '/qr-management',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qr-management.image' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'qr-management/{id}/image',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\QRManagementController@displayImage',
        'controller' => 'App\\Http\\Controllers\\QRManagementController@displayImage',
        'as' => 'qr-management.image',
        'namespace' => NULL,
        'prefix' => '/qr-management',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qr-management.download' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'qr-management/{id}/download',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin,pastor',
        ),
        'uses' => 'App\\Http\\Controllers\\QRManagementController@downloadImage',
        'controller' => 'App\\Http\\Controllers\\QRManagementController@downloadImage',
        'as' => 'qr-management.download',
        'namespace' => NULL,
        'prefix' => '/qr-management',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'mobile.home' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mobile',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:43:"function() { return \\view(\'mobile.home\'); }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000b040000000000000000";}}',
        'as' => 'mobile.home',
        'namespace' => NULL,
        'prefix' => '/mobile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'mobile.login' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mobile/login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:44:"function() { return \\view(\'mobile.login\'); }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000bcc0000000000000000";}}',
        'as' => 'mobile.login',
        'namespace' => NULL,
        'prefix' => '/mobile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'mobile.register' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mobile/register',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:47:"function() { return \\view(\'mobile.register\'); }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000bce0000000000000000";}}',
        'as' => 'mobile.register',
        'namespace' => NULL,
        'prefix' => '/mobile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'mobile.checkin' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mobile/checkin',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:46:"function() { return \\view(\'mobile.checkin\'); }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000bd00000000000000000";}}',
        'as' => 'mobile.checkin',
        'namespace' => NULL,
        'prefix' => '/mobile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'mobile.service-checkin' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mobile/service-checkin',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:54:"function() { return \\view(\'mobile.service-checkin\'); }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000bd20000000000000000";}}',
        'as' => 'mobile.service-checkin',
        'namespace' => NULL,
        'prefix' => '/mobile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'mobile.visitor-register' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mobile/visitor-register',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:55:"function() { return \\view(\'mobile.visitor-register\'); }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000bd40000000000000000";}}',
        'as' => 'mobile.visitor-register',
        'namespace' => NULL,
        'prefix' => '/mobile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'mobile.member-register' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mobile/member-register',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:54:"function() { return \\view(\'mobile.member-register\'); }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000bd60000000000000000";}}',
        'as' => 'mobile.member-register',
        'namespace' => NULL,
        'prefix' => '/mobile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'mobile.give' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mobile/give',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:43:"function() { return \\view(\'mobile.give\'); }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000bd80000000000000000";}}',
        'as' => 'mobile.give',
        'namespace' => NULL,
        'prefix' => '/mobile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'mobile.payment' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mobile/payment',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:46:"function() { return \\view(\'mobile.payment\'); }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000bda0000000000000000";}}',
        'as' => 'mobile.payment',
        'namespace' => NULL,
        'prefix' => '/mobile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'mobile.payment-success' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mobile/payment-success',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:54:"function() { return \\view(\'mobile.payment-success\'); }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000bdc0000000000000000";}}',
        'as' => 'mobile.payment-success',
        'namespace' => NULL,
        'prefix' => '/mobile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'mobile.equipment' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mobile/equipment/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:66:"function($id) { return \\view(\'mobile.equipment\', [\'id\' => $id]); }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000bde0000000000000000";}}',
        'as' => 'mobile.equipment',
        'namespace' => NULL,
        'prefix' => '/mobile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'mobile.program-register' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mobile/program-register/{program}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:88:"function($program) { return \\view(\'mobile.program-register\', [\'program\' => $program]); }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000be00000000000000000";}}',
        'as' => 'mobile.program-register',
        'namespace' => NULL,
        'prefix' => '/mobile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'mobile.church-info' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mobile/church-info',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:50:"function() { return \\view(\'mobile.church-info\'); }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000be20000000000000000";}}',
        'as' => 'mobile.church-info',
        'namespace' => NULL,
        'prefix' => '/mobile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'mobile.dashboard' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mobile/dashboard',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:48:"function() { return \\view(\'mobile.dashboard\'); }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000be40000000000000000";}}',
        'as' => 'mobile.dashboard',
        'namespace' => NULL,
        'prefix' => '/mobile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'mobile.profile' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mobile/profile',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:46:"function() { return \\view(\'mobile.profile\'); }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000be60000000000000000";}}',
        'as' => 'mobile.profile',
        'namespace' => NULL,
        'prefix' => '/mobile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'mobile.profile-edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mobile/profile-edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:51:"function() { return \\view(\'mobile.profile-edit\'); }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000be80000000000000000";}}',
        'as' => 'mobile.profile-edit',
        'namespace' => NULL,
        'prefix' => '/mobile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'mobile.settings' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mobile/settings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:47:"function() { return \\view(\'mobile.settings\'); }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000bea0000000000000000";}}',
        'as' => 'mobile.settings',
        'namespace' => NULL,
        'prefix' => '/mobile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'mobile.giving' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mobile/giving',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:45:"function() { return \\view(\'mobile.giving\'); }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000bec0000000000000000";}}',
        'as' => 'mobile.giving',
        'namespace' => NULL,
        'prefix' => '/mobile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'mobile.giving-history' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mobile/giving-history',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:53:"function() { return \\view(\'mobile.giving-history\'); }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000bee0000000000000000";}}',
        'as' => 'mobile.giving-history',
        'namespace' => NULL,
        'prefix' => '/mobile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'mobile.events' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mobile/events',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:45:"function() { return \\view(\'mobile.events\'); }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000bf00000000000000000";}}',
        'as' => 'mobile.events',
        'namespace' => NULL,
        'prefix' => '/mobile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'mobile.event-details' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mobile/event-details/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:70:"function($id) { return \\view(\'mobile.event-details\', [\'id\' => $id]); }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000bf20000000000000000";}}',
        'as' => 'mobile.event-details',
        'namespace' => NULL,
        'prefix' => '/mobile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'mobile.event-register' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mobile/event-register/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:71:"function($id) { return \\view(\'mobile.event-register\', [\'id\' => $id]); }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000bf40000000000000000";}}',
        'as' => 'mobile.event-register',
        'namespace' => NULL,
        'prefix' => '/mobile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'mobile.announcements' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mobile/announcements',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:52:"function() { return \\view(\'mobile.announcements\'); }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000bf60000000000000000";}}',
        'as' => 'mobile.announcements',
        'namespace' => NULL,
        'prefix' => '/mobile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'mobile.attendance' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mobile/attendance',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:49:"function() { return \\view(\'mobile.attendance\'); }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000bf80000000000000000";}}',
        'as' => 'mobile.attendance',
        'namespace' => NULL,
        'prefix' => '/mobile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'mobile.attendance-history' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mobile/attendance-history',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:57:"function() { return \\view(\'mobile.attendance-history\'); }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000bfa0000000000000000";}}',
        'as' => 'mobile.attendance-history',
        'namespace' => NULL,
        'prefix' => '/mobile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'mobile.children-ministry' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mobile/children-ministry',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:56:"function() { return \\view(\'mobile.children-ministry\'); }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000bfc0000000000000000";}}',
        'as' => 'mobile.children-ministry',
        'namespace' => NULL,
        'prefix' => '/mobile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'mobile.equipment-management' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mobile/equipment-management',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:59:"function() { return \\view(\'mobile.equipment-management\'); }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000bfe0000000000000000";}}',
        'as' => 'mobile.equipment-management',
        'namespace' => NULL,
        'prefix' => '/mobile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'mobile.shepherd.dashboard' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mobile/shepherd/dashboard',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'role:admin,pastor',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:57:"function() { return \\view(\'mobile.shepherd.dashboard\'); }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000c020000000000000000";}}',
        'as' => 'mobile.shepherd.dashboard',
        'namespace' => NULL,
        'prefix' => 'mobile/shepherd',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'mobile.shepherd.record-visit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mobile/shepherd/record-visit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'role:admin,pastor',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:60:"function() { return \\view(\'mobile.shepherd.record-visit\'); }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000c040000000000000000";}}',
        'as' => 'mobile.shepherd.record-visit',
        'namespace' => NULL,
        'prefix' => 'mobile/shepherd',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'mobile.shepherd.visit-history' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mobile/shepherd/visit-history',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'role:admin,pastor',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:61:"function() { return \\view(\'mobile.shepherd.visit-history\'); }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000c060000000000000000";}}',
        'as' => 'mobile.shepherd.visit-history',
        'namespace' => NULL,
        'prefix' => 'mobile/shepherd',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'mobile.shepherd.message-flock' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mobile/shepherd/message-flock',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'role:admin,pastor',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:61:"function() { return \\view(\'mobile.shepherd.message-flock\'); }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000c080000000000000000";}}',
        'as' => 'mobile.shepherd.message-flock',
        'namespace' => NULL,
        'prefix' => 'mobile/shepherd',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'mobile.shepherd.performance' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mobile/shepherd/performance',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'role:admin,pastor',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:59:"function() { return \\view(\'mobile.shepherd.performance\'); }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000c0a0000000000000000";}}',
        'as' => 'mobile.shepherd.performance',
        'namespace' => NULL,
        'prefix' => 'mobile/shepherd',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'mobile.service-unit.dashboard' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mobile/service-unit/dashboard',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'role:admin,pastor,staff',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:61:"function() { return \\view(\'mobile.service-unit.dashboard\'); }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000c0c0000000000000000";}}',
        'as' => 'mobile.service-unit.dashboard',
        'namespace' => NULL,
        'prefix' => 'mobile/service-unit',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'mobile.service-unit.manage' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mobile/service-unit/manage',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'role:admin,pastor,staff',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:58:"function() { return \\view(\'mobile.service-unit.manage\'); }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000c0e0000000000000000";}}',
        'as' => 'mobile.service-unit.manage',
        'namespace' => NULL,
        'prefix' => 'mobile/service-unit',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'mobile.service-unit.roster' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mobile/service-unit/roster',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'role:admin,pastor,staff',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:58:"function() { return \\view(\'mobile.service-unit.roster\'); }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000c100000000000000000";}}',
        'as' => 'mobile.service-unit.roster',
        'namespace' => NULL,
        'prefix' => 'mobile/service-unit',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'mobile.service-unit.duty-tasks' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mobile/service-unit/duty-tasks',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'role:admin,pastor,staff',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:62:"function() { return \\view(\'mobile.service-unit.duty-tasks\'); }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000c120000000000000000";}}',
        'as' => 'mobile.service-unit.duty-tasks',
        'namespace' => NULL,
        'prefix' => 'mobile/service-unit',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
  ),
)
);
