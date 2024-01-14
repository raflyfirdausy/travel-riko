 <!-- ======= Footer ======= -->
 <footer id="footer" class="footer">
     <div class="copyright">
         Copyright &copy; <?= date("Y") ?> <strong><span><?= env("APP_NAME") ?></span></strong> All Rights Reserved | Made with ❤️ by <a href="https://instagram.com/rafly_firdausy"><strong>Ultranesia.com</strong></a>
     </div>
     <div class="credits">
         Version <strong><?= VERSION ?></strong> | Rendered by <strong><?= $this->benchmark->elapsed_time() ?></strong> second and <strong><?= $this->benchmark->memory_usage() ?></strong> Memory <span><?= env("APP_ENV") != "production" ? " | DEV" : "" ?></span>
     </div>
 </footer><!-- End Footer -->

 <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>