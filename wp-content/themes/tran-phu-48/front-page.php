<?php get_header(); ?>
<main id="main">
    <section class="hero" aria-labelledby="hero-title">
        <img class="hero-image" src="<?php echo esc_url(tp48_image('hero')); ?>" alt="Tháp Trầm Hương bên bờ biển Nha Trang khi thành phố lên đèn" fetchpriority="high">
        <div class="hero-content">
            <h1 id="hero-title"><span class="hero-title-line"><span class="hero-number">48</span> TRẦN PHÚ</span><span class="hero-city">NHA TRANG</span></h1>
            <div class="gold-line"></div>
            <p class="hero-tagline"><?php echo esc_html(tp48_text('headline', 'Dấu ấn mới bên vịnh biển')); ?></p>
            <p class="hero-subtitle"><?php echo esc_html(tp48_text('subtitle', 'A New Landmark on Nha Trang Bay')); ?></p>
            <a class="button outline" href="#vi-tri">Discover more <span aria-hidden="true">⟶</span></a>
        </div>
    </section>
    <nav class="pillars" aria-label="Khám phá 48 Trần Phú">
        <?php foreach ([['pin','Vị trí đắc địa','vi-tri'],['waves','Bên vịnh biển','dau-an'],['star','Dấu ấn đô thị','dau-an'],['diamond','Giá trị bền vững','kham-pha']] as $item): ?>
        <a href="#<?php echo esc_attr($item[2]); ?>"><?php echo tp48_icon($item[0]); ?><span><?php echo esc_html($item[1]); ?></span><span class="mobile-chevron" aria-hidden="true">›</span></a>
        <?php endforeach; ?>
    </nav>
    <section class="location ruled" id="vi-tri" aria-labelledby="location-title">
        <img src="<?php echo esc_url(tp48_image('location')); ?>" alt="Toàn cảnh đường Trần Phú và đường cong vịnh Nha Trang" loading="lazy">
        <div class="location-copy">
            <h2 id="location-title"><span>Vị trí</span>48 Trần Phú</h2>
            <p><?php echo esc_html(tp48_text('location', 'Tọa lạc trên tuyến đường ven biển Trần Phú, bên cạnh Quảng trường 2/4 và Tháp Trầm Hương – trái tim của thành phố Nha Trang.')); ?></p>
            <a class="text-link" href="https://www.google.com/maps/search/?api=1&amp;query=48+Tran+Phu+Nha+Trang" target="_blank" rel="noopener noreferrer">Khám phá vị trí <span aria-hidden="true">⟶</span></a>
        </div>
    </section>
    <section class="identity ruled" id="dau-an" aria-labelledby="identity-title">
        <img src="<?php echo esc_url(tp48_image('sunrise')); ?>" alt="Ánh bình minh trên vịnh biển Nha Trang" loading="lazy">
        <div class="identity-copy"><h2 id="identity-title">Dấu ấn<br>Nha Trang</h2><div class="short-line"></div><p><?php echo esc_html(tp48_text('identity', 'Thành phố của biển, ánh sáng và những giá trị sống đặc trưng.')); ?></p></div>
    </section>
    <section class="gallery ruled" id="hinh-anh" aria-labelledby="gallery-title">
        <div class="gallery-copy"><h2 id="gallery-title">Hình ảnh</h2><p>Những khoảnh khắc tiêu biểu<br>về vị trí, cảnh quan và phố biển<br>Nha Trang.</p><button class="text-link" data-open-gallery>Xem hình ảnh <span aria-hidden="true">⟶</span></button></div>
        <div class="gallery-grid">
            <?php foreach ([['location','Đường bờ biển Nha Trang'],['hero','Tháp Trầm Hương về đêm'],['sunrise','Bình minh trên vịnh biển']] as $i => $photo): ?>
            <a class="gallery-item" href="<?php echo esc_url(tp48_image($photo[0])); ?>" data-gallery-index="<?php echo (int) $i; ?>" data-caption="<?php echo esc_attr($photo[1]); ?>" aria-label="Xem ảnh: <?php echo esc_attr($photo[1]); ?>"><img src="<?php echo esc_url(tp48_image($photo[0])); ?>" alt="<?php echo esc_attr($photo[1]); ?>" loading="lazy"><span aria-hidden="true">↗</span></a>
            <?php endforeach; ?>
        </div>
    </section>
    <section class="journal ruled" id="nhat-ky" aria-labelledby="journal-title">
        <img class="journal-image" src="<?php echo esc_url(tp48_image('journal')); ?>" alt="Ảnh minh họa hoạt động xây dựng" loading="lazy">
        <h2 id="journal-title">Nhật ký<br>công trình<span class="short-line"></span></h2>
        <div class="journal-copy"><p>Cập nhật tiến độ thi công, hình ảnh thực tế<br>và những dấu mốc quan trọng của dự án.</p><button class="text-link" aria-expanded="false" aria-controls="journal-entries" data-journal-toggle>Theo dõi nhật ký <span aria-hidden="true">⟶</span></button></div>
    </section>
    <section id="journal-entries" class="journal-entries" aria-label="Các bài nhật ký" hidden>
        <?php $journal = new WP_Query(['post_type' => 'tp48_journal', 'posts_per_page' => 6]); ?>
        <?php if ($journal->have_posts()): while ($journal->have_posts()): $journal->the_post(); ?>
            <article><time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('d.m.Y')); ?></time><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><?php the_excerpt(); ?></article>
        <?php endwhile; else: ?><p>Nhật ký công trình sẽ được cập nhật tại đây khi có thông tin chính thức.</p><?php endif; wp_reset_postdata(); ?>
    </section>
    <section class="contact ruled" id="kham-pha" aria-labelledby="contact-title">
        <h2 id="contact-title">Khám phá thêm<br>về 48 Trần Phú</h2>
        <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" class="contact-form">
            <input type="hidden" name="action" value="tp48_contact"><?php wp_nonce_field('tp48_contact', 'tp48_nonce'); ?>
            <div class="honeypot" aria-hidden="true"><label>Website<input name="website" tabindex="-1" autocomplete="off"></label></div>
            <label class="sr-only" for="full-name">Họ và tên</label><input id="full-name" name="full_name" placeholder="Họ và tên" autocomplete="name" maxlength="100" required>
            <label class="sr-only" for="phone">Số điện thoại</label><input id="phone" name="phone" type="tel" placeholder="Số điện thoại" autocomplete="tel" pattern="[+0-9 \(\)\.\-]{8,20}" maxlength="20" required>
            <label class="sr-only" for="email">Email</label><input id="email" name="email" type="email" placeholder="Email" autocomplete="email" maxlength="254" required>
            <button class="button gold" type="submit">Discover more <span aria-hidden="true">⟶</span></button>
            <span class="form-note">Thông tin được sử dụng để phản hồi yêu cầu tìm hiểu của bạn.</span>
        </form>
        <?php $messages = ['success' => 'Cảm ơn bạn. Thông tin của bạn đã được ghi nhận.', 'invalid' => 'Vui lòng nhập đầy đủ họ tên, số điện thoại và email hợp lệ.', 'expired' => 'Phiên gửi đã hết hạn. Vui lòng tải lại trang và thử lại.', 'wait' => 'Bạn vừa gửi thông tin. Vui lòng chờ một phút trước khi gửi lại.', 'error' => 'Chưa thể gửi thông tin. Vui lòng thử lại.']; $status = sanitize_key($_GET['contact'] ?? ''); if (isset($messages[$status])): ?>
        <p class="form-status" role="status"><?php echo esc_html($messages[$status]); ?></p>
        <?php endif; ?>
    </section>
</main>
<dialog class="lightbox" aria-label="Thư viện hình ảnh"><button class="lightbox-close" aria-label="Đóng thư viện">×</button><button class="lightbox-prev" aria-label="Ảnh trước">←</button><figure><img src="<?php echo esc_url(tp48_image('location')); ?>" alt=""><figcaption></figcaption></figure><button class="lightbox-next" aria-label="Ảnh tiếp theo">→</button></dialog>
<?php get_footer(); ?>
