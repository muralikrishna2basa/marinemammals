<?php

namespace AppBundle\ControllerHelper;

use AppBundle\Entity\Users;
use AppBundle\Entity\RequestLoans;
use AppBundle\Entity\User2Requests;

class RequestLoansProvider
{

    private $doctrine;
    private $repo;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
        $this->repo = $this->doctrine->getRepository('AppBundle:RequestLoans');
        //$this->cgRefCodesPropertiesSet = new CgRefCodesPropertiesSet($doctrine);
    }

    /***
     * @param Users $user
     * @return mixed
     *
     * Get all the RequestLOans of the provided user
     */
    public function loadUserRequests(Users $user){
        $requests = $this->repo->getUserRequests($user);
        return $requests;
    }

    /***
     * @param Users $user
     * @return RequestLoans
     *
     *Build a new RequestLOan object with related objects with the given user
     */
 public function prepareNewRequestLoan(Users $user){
        $request = new RequestLoans();
        $user2request = new User2Requests();
        $user2request->setUsrSeqno($user); //add the p2r type later, important, make this choosable
        //$user2request->getP2rType();
        $request->addUser2Requests($user2request);

        return $request;
    }

}