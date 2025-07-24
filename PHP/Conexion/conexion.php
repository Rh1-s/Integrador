<?php
class Conexion
{
    private $cn = null;
    function conecta()
    {
        if ($this->cn == null) {
<<<<<<< HEAD
            $this->cn = mysqli_connect("localhost", "root", "", "Institucion");
=======
            $this->cn = mysqli_connect("localhost", "root", "", "colegio");
>>>>>>> 8ca8bcfc0866877ba38f83eaefa8297c15944642
        }
        return $this->cn;
    }
}
