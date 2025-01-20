<a href="<?php echo esc_url($product->product_url); ?>" target="_blank" style="text-decoration: none; color: inherit;">
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-center align-items-center">
                <img src="<?php echo esc_url($product->image_url); ?>" alt="<?php echo esc_attr($product->title); ?>" class="img-fluid" style="max-height: 200px; width: auto; margin: 0 auto; display: block;">
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <center><button class="btn btn-primary btn-sm">Jetzt auf Amazon ansehen *</button></center>
            </div>
        </div>
    </div>
</a>
