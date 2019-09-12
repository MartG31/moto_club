<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MasterController extends AbstractController
{
    public $rank = array(
        'membre' => 1,
        'adherent' => 2,
        'bureau' => 3,
        'admin' => 4,
    );

    protected function checkEnglishDate(string $date) {
        $exp = explode('-', $date);
        return checkdate($exp[1], $exp[2], $exp[0]);
    }

    protected function mergeDateTime(string $date, string $time) {
    	$exp_date = explode('-', $date);
    	$exp_time = explode(':', $time);

    	$dt = new \DateTime();
    	$dt->setDate($exp_date[0], $exp_date[1], $exp_date[2]);
    	$dt->setTime($exp_time[0], $exp_time[1]);

    	return $dt;
    }
}