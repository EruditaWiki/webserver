<!--
LEGAL NOTICE

  This project contains software solution.

  Please check the LICENSE OF THIS PROJECT below, to find the license 
  information for this project. This license is just related to the 
  contained software solution and its source code, as far as the 
  software solution was developed by the copyright holder.
  This license bases on [bsd-3], but some modifications make it 
  different from regular BSD-Licences. 

  Errors, changes and deviations are not impossible!

  The project was developed and tested with the software 
  [Apache 2.4 VS16] in connexion with [php 8.1.3].
  [Apache 2.4 VS16] and [php 8.1.3] will not be delivered/distributed 
  as parts of this project. 
  The project uses elements of [Bootstrap 4.5.3].
  
LICENSE OF THIS PROJECT

  This license bases on [bsd-3] with fundamental modifications:

  Copyright 2023 Kevin Tamme, IU University of Applied Sciences, 
  Nordring 53, 63517 Rodenbach, Germany

  Copyright 2023 Dominik Hein, IU University of Applied Sciences, 
  Am Bobenhäuserweg 9, 63773 Goldbach, Germany

  Copyright 2023 Rares-Constantin Velnic, IU University of Applied Sciences, 
  Am Melonenberg 6, 65187 Wiesbaden, Germany

  The use of this project is only allowed in the context of 
  the lecture to facilitate the understanding of programming 
  techniques. Redistribution and use in source or binary forms, with 
  or without modification, are not allowed. 

  DISCLAIMER [bsd-3]: 
   THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS 
   "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT 
   LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS 
   FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE 
   COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, 
   INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, 
   BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; 
   LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER 
   CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT 
   LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN 
   ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE 
   POSSIBILITY OF SUCH DAMAGE.

REFERENCES

  [bsd-3] Open Source Initiative (n. Y.): "The 3-Clause BSD License". 
     URL: https://opensource.org/licenses/BSD-3-Clause, 
     accessed 2023-FEB-07.
  [Apache 2.4 VS16] Apache Lounge powered by Apache (2021): 
     "Apache 2.4 VS16 Windows Binaries and Modules". Version 2.4.52 Win64. 
     Online available at URL: https://www.apachelounge.com/download/, 
     accessed 2023-FEB-07. 
     [License-URL: https://www.apachelounge.com/contact.html].
  [php 8.1.3] The PHP Group (2022): "PHP: Hypertext Preprocessor". 
     Version 8.1.3. Online available at 
     URL: https://windows.php.net/download/, accessed 2023-FEB-07. 
     [License: PHP License v3.01, 
     License-URL: https://www.php.net/license/3_01.txt].
  [Bootstrap 4.5.3] Mark Otto / Jacob Thornton / XhmikosR / GeoSot / 
     Rohit Sharma / alpadev / Gael Poupard / Patrick H. Lauke /
     Martijn Cuppend / Johann-S / Gleb Mazovetskiy (2022): "Bootstrap".
     Version 4.5.3. Bootstrap is released under the MIT license 
     and is copyright 2022 Twitter. Online available at
     URL: https://getbootstrap.com/, accessed 2023-FEB-07.
     [Bootstrap v4.5.3 (https://getbootstrap.com/), 
     Copyright 2011-2023 The Bootstrap Authors, 
     Copyright 2011-2023 Twitter, Inc., 
     Licensed under MIT 
     (https://github.com/twbs/bootstrap/blob/main/LICENSE)].

BOOTSTRAP 4.5.3 LICENSE

Copyright (c) 2011-2023 The Bootstrap Authors

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
-->
<?php

// not neccessary because legal notice already started the session
// session_start();

require_once('config.php');
require_once('functions.php');
require_once('bootstrap.php');
require_once('scrollbar.php');



if (isset($_SESSION['user'])) {
  $user = getUser($_SESSION['user']);
}

?>

<head>
  <link rel="shortcut icon" type="image/x-icon" href="assets/v2.png">
</head>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <div class="navbar-brand">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item">
          <a class="navbar-brand" href="index.php">
            <img src="assets/v2_round.png" alt="Logo" class="mr-2" width="32" height="32">
            Erudita
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="categories.php">Categories</a>
        </li>
        <?php if (isset($_SESSION['user'])): ?>
          <li class="nav-item">
            <a class="nav-link" href="edit.php">Create</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="chat.php">Chat</a>
          </li>
        <?php endif; ?>
        <li class="nav-item">
          <a class="nav-link" href="about.php">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="faq.php">FAQ</a>
        </li>
      </ul>
    </div>
    <ul class="navbar-nav ml-auto">
      <?php if (isset($_SESSION['user'])): ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="index.php" id="navbarDropdownMenuLink" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php if (isset($user['profile_image'])): ?>
              <img src="<?php echo $user['profile_image']; ?>" width="32" height="32">
            <?php endif; ?>
            <?php echo htmlspecialchars($user['username']); ?>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="profile.php">Profile</a>
            <a class="dropdown-item" href="logout.php">Logout</a>
          </div>
        </li>
      <?php else: ?>
        <li class="nav-item">
          <a class="nav-link" href="login.php">Sign In</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="register.php">Sign Up</a>
        </li>
      <?php endif; ?>
    </ul>
  </div>
</nav>