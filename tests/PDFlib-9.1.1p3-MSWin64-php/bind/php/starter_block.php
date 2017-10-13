<?php

/* $Id: starter_block.php,v 1.11.2.3 2016/07/22 14:06:26 rp Exp $
 *
 * Block starter:
 * Import a PDF page containing blocks and fill text and image
 * blocks with some data. For each addressee of the simulated
 * mailing a separate page with personalized information is
 * generated.
 * A real-world application would fill the Blocks with data from
 * some external data source. We simulate this with static data.
 *
 * Required software: PPS 9
 * Required data: input PDF, image
 */

/* This is where the data files are. Adjust as necessary. */
$searchpath = dirname(dirname(__FILE__)).'/data';
$outfile = "";
$infile = "block_template.pdf";
$imagefile = "new.jpg";

/* Names of the recipient-specific Blocks contained on the imported page */
$addressblocks = array(
    "name", "street", "city"
);

/* number of address blocks */
$nblocks = count($addressblocks);

/* Personalization data for the recipients */
$recipients = array(
    array("Mr Maurizio Moroni", "Strada Provinciale 124", "Reggio Emilia"),
    array("Ms Dominique Perrier", "25, rue Lauriston", "Paris"),
    array("Mr Liu Wong", "55 Grizzly Peak Rd.", "Butte")
);

$nrecipients = count($recipients);

/* Static text simulates database-driven main contents */
$blockdata = array(
  array("intro", "Dear Paper Planes Fan,"),
  array("announcement",
    "Our <fillcolor=red>BEST PRICE OFFER<fillcolor=black> includes today:" .
    "\n\n" .
    "Long Distance Glider\nWith this paper rocket you can send all your " .
    "messages even when sitting in a hall or in the cinema pretty near " .
    "the back.\n\n" .
    "Giant Wing\nAn unbelievable sailplane! It is amazingly robust and " .
    "can even do aerobatics. But it is best suited to gliding.\n\n" .
    "Cone Head Rocket\nThis paper arrow can be thrown with big swing. " .
    "We launched it from the roof of a hotel. It stayed in the air a " .
    "long time and covered a considerable distance.\n\n" .
    "Super Dart\nThe super dart can fly giant loops with a radius of 4 " .
    "or 5 meters and cover very long distances. Its heavy cone point is " .
    "slightly bowed upwards to get the lift required for loops.\n\n" .
    "Visit us on our Web site at www.kraxi.com!"),
  array("goodbye", "Yours sincerely,\nVictor Kraxi")
);

try {
    $p = new pdflib();

    $p->set_option("SearchPath={{" . $searchpath . "}}");

    /* This means we must check return values of load_font() etc. */
    $p->set_option("errorpolicy=return");

    /* Enable the following line if you experience crashes on OS X
     * (see PDFlib-in-PHP-HowTo.pdf for details):
     * $p->set_option("usehostfonts=false");
     */

    /* all strings are expected as utf8 */
    $p->set_option("stringformat=utf8");


    if ($p->begin_document($outfile,
	    "destination={type=fitwindow} pagelayout=singlepage") == 0) {
      throw new Exception("Error: " . $p->get_errmsg());
    }

    $p->set_info("Creator", "PDFlib starter sample");
    $p->set_info("Title", "starter_block");

    /* Open the Block template which contains PDFlib Blocks */
    $indoc = $p->open_pdi_document($infile, "");
    if ($indoc == 0) {
      throw new Exception("Error: " . $p->get_errmsg());
    }
    $no_of_input_pages = $p->pcos_get_number($indoc, "length:pages");
    /* Prepare all pages of the input document. We assume a small
     * number of input pages and a large number of generated output
     * pages. Therefore it makes sense to keep the input pages
     * open instead of opening the pages again for each recipient.
     */
     
    for ($pageno = 1; $pageno <= $no_of_input_pages; $pageno++){
      /* Open the first page and clone the page size */
      $pagehandles[$pageno] = $p->open_pdi_page($indoc, $pageno, "cloneboxes");
      if ($pagehandles[$pageno] == 0) {
        throw new Exception("Error: " . $p->get_errmsg());
      }
    }

    $image = $p->load_image("auto", $imagefile, "");

    if ($image == 0) {
      throw new Exception("Error: " . $p->get_errmsg());
    }
    
    /* Duplicate input pages for each recipient and fill Blocks */

    for ($i = 0; $i < $nrecipients; $i++)
    {
      /* Loop over all pages of the input document */
      for ($pageno = 1; $pageno <= $no_of_input_pages; $pageno++){
        /* Start the next output page. The dummy size will be
         * replaced with the cloned size of the input page.
         */
         
        $p->begin_page_ext(10, 10, "");

        /* Place the imported page on the output page, and clone all
         * page boxes which are present in the input page; this will
         * override the dummy size used in begin_page_ext().
         */
        $p->fit_pdi_page($pagehandles[$pageno], 0, 0, "cloneboxes");

        /* Option list for text blocks */
        $optlist = "encoding=unicode embedding";

        /* Loop over all recipient-specific Blocks. Fill each
         * Block with the corresponding person's address data.
         */
        for ($j = 0; $j < count($addressblocks); $j++) {
            /* Check whether the Block is present on the imported page;
             * type "dictionary" means that the Block is present.
             */
            $objtype = $p->pcos_get_string($indoc, 
                "type:pages[" . ($pageno-1) . "]/blocks/" . $addressblocks[$j]);
            if ($objtype == "dict"){
              if ($p->fill_textblock($pagehandles[$pageno], $addressblocks[$j],
                $recipients[$i][$j], $optlist) == 0)
                printf("Warning: %s\n", $p->get_errmsg());
            }
        }
        
        /* Loop over the remaining text Blocks. These are filled with 
         * the same data for each recipient. 
         */
        for ($j = 0; $j < count($blockdata); $j++) {
          /* Check whether the Block is present on the page */
          $objtype = $p->pcos_get_string($indoc, 
                "type:pages[" . ($pageno-1) . "]/blocks/" . $blockdata[$j][0]);
                
          if ($objtype == "dict"){
            if ($p->fill_textblock($pagehandles[$pageno], $blockdata[$j][0],
              $blockdata[$j][1], $optlist) == 0)
                printf("Warning: %s\n", $p->get_errmsg());
          }
        }
        
        /* Fill the icon Block if it is present on the imported page */
        $objtype = $p->pcos_get_string($indoc, 
                "type:pages[" . ($pageno-1) . "]/blocks/icon");
                
        if ($objtype == "dict"){
          if ($p->fill_imageblock($pagehandles[$pageno], "icon", $image, "") == 0)
              printf("Warning: %s\n", $p->get_errmsg());
        }

        $p->end_page_ext("");
      }
    }

    /* Close all input pages */
    for ($pageno = 1; $pageno <= $no_of_input_pages; $pageno++){
      $p->close_pdi_page($pagehandles[$pageno]);
    }
    $p->close_pdi_document($indoc);
    $p->close_image($image);

    $p->end_document("");

    $buf = $p->get_buffer();
    $len = strlen($buf);

    header("Content-type: application/pdf");
    header("Content-Length: $len");
    header("Content-Disposition: inline; filename=starter_block.pdf");
    print $buf;

}
catch (PDFlibException $e) {
    die("PDFlib exception occurred in starter_block sample:\n" .
        "[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " .
        $e->get_errmsg() . "\n");
}
catch (Exception $e) {
    die($e);
}

$p = 0;
?>
