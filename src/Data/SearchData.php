<?php
namespace App\Data;

class SearchData
{
    /**
     * @var string
     */
    public $q = '';

    /**
     * @var Taille[]
     */
    public $taille = [];

    /**
     * @var Sex[]
     */
    public $sex = [];

    /**
     * @var Categorie[]
     */
    public $categorie = [];

    /**
     * @var null|int
     */
    public $prixMax;

    /**
     * @var null|int
     */
    public $prixMin;

}