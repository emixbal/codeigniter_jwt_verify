# Membuat helper untuk verify token pada Codeigniter

Karena pada codeigniter 3.x.x tidak menyediakan Middleware dan router yang "biasa", maka saya menggunakan helper untuk melakukan verify setiap request apakah valid atau tidak.

### Instalasi:
- Copy file helper "jwtauth_helper.php" ke dalam directory helper codeigniter.
- Load helper tersebut. Sebaiknya di-autoload
- Contoh penggunaan helper pada controller Example.php