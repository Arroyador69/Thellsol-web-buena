<?php
// Script para generar los hashes de las contraseñas de los usuarios admin

echo "andre: " . password_hash('thellsol_2025', PASSWORD_DEFAULT) . "<br>";
echo "admin: " . password_hash('thellsol_2025_bueno', PASSWORD_DEFAULT) . "<br>";
?> 