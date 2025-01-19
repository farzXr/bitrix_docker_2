 <?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
?>
 </main>
 <footer>
     <div class="pagination">
         <?php
         echo $res->GetPageNavStringEx(
             $navComponentObject,
             "Книги:",
             ".default",
             false
         ); ?>
     </div>
 </footer>
 </body>
 </html>




