<?php

namespace App\Helper;

use Illuminate\Http\Request;
// use Section8\ApiAuth\TokenAuthFacades;

use App\Helper\Contracts\AuthInterface;

class Auth implements AuthInterface
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Authenticated user.
     */
    protected $user;

    /**
     * All available user types.
     * 
     * @var array
     */
    protected $types = [
        'merchant',
        'customer',
        'employee',
        'admin'
    ];

    /**
     * Create the class instance and inject its dependencies.
     * 
     * @param Illuminate\Http\Request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;

        $this->init();
    }

    /**
     * Get authenticated user and identify its type.
     * 
     */
    protected function init()
    {
        foreach ($this->types as $key => $value) {
            $user = null; // TokenAuthFacades::getUser($this->request, $value);

            if (isset($user)) {
                $user->type = strtoupper($value);

                $this->user = $user;

                break;
            }
        }

        return $this;
    }

    /**
     * Return the authenticated user.
     * 
     * @return mixed
     */
    public function user()
    {
        return $this->user;
    }

    /**
     * Return merchant uuid of authenticated user.
     * 
     * @return mixed
     */
    public function merchantUuid()
    {
        switch ($this->userType()) {
            case 'MERCHANT':
            case 'CUSTOMER':
            case 'EMPLOYEE':
                return isset($this->user) ? $this->user->merchant_uuid : null;

            case 'ADMIN':
                return isset($this->user) ? $this->user->uuid : null;

            default:
                return null;
        }
    }

    /**
     * Return uuid of authenticated user.
     * 
     * @return mixed
     */
    public function userUuid()
    {
        switch ($this->userType()) {
            case 'MERCHANT':
                return isset($this->user) ? $this->user->merchant_uuid : null;

            case 'CUSTOMER':
            case 'EMPLOYEE':
            case 'ADMIN':
                return isset($this->user) ? $this->user->uuid : null;

            default:
                return null;
        }
    }

    /**
     * Return user type of authenticated user.
     * 
     * @return mixed
     */
    public function userType()
    {
        return isset($this->user) ? $this->user->type : null;
    }

    /**
     * Merge the authenticated user to form request.
     * 
     * @return Illuminate\Http\Request
     */
    public function merge()
    {
        if (isset($this->user)) $this->request->merge(['auth' => $this->user]);

        return $this->request;
    }
}
