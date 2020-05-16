<?php

namespace App\Service\Reservation;

use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ReservationService{

    protected $session;
    protected $produitRepository;

    public function __construct(SessionInterface $session, ProduitRepository $produitRepository)
    {
        $this->session = $session;
        $this->produitRepository = $produitRepository;
    }

    public function add(int $id)
    {
        $reservation = $this->session->get('reservation', []);
        if(!empty($reservation[$id])){
            $reservation[$id]++;
        }else{
            $reservation[$id] = 1;
        }
        $this->session->set('reservation', $reservation);
    }

    public function remove(int $id)
    {
        $reservation = $this->session->get('reservation', []);
        if(!empty($reservation[$id])){
            unset($reservation[$id]);
        }
        $this->session->set('reservation', $reservation);
    }

    public function getFullReservation() : array
    {
        $reservation = $this->session->get('reservation', []);
        $reservationInfo = [];
        foreach ($reservation as $id => $quantity){
            $reservationInfo[] = [
                'produit' => $this->produitRepository->find($id),
                'quantity' => $quantity
            ];
        }
        return $reservationInfo;
    }

    public function getTotal() : float
    {
        $total=0;
        foreach ($this->getFullReservation() as $item){
            $total += $item['produit']->getPrixht() * $item['quantity'];
        }
        return $total;
    }
}