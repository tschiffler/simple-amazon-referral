<a href="<?php echo esc_url($product->product_url); ?>" target="_blank" style="text-decoration: none; color: inherit;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center"><?php echo esc_html($product->title); ?></h1>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-6">
                <p><?php echo esc_html($product->description); ?></p>
            </div>
            <div class="col-6 text-center">
                <img src="<?php echo esc_url($product->image_url); ?>" alt="<?php echo esc_attr($product->title); ?>" class="img-fluid">
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <button class="btn btn-primary">Jetzt auf Amazon ansehen</button>
            </div>
        </div>
    </div>
</a>
