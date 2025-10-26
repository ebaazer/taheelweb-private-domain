<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
  
    <?php foreach($all_data_question as $all_data_row) { ?>

    <url>
        <loc><?= $all_data_row['url']; ?></loc>
        <priority>0.5</priority>
    </url>

    <?php } ?>

</urlset> 
