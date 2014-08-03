<div class="gh-profile-widget vcard" itemscope="" itemtype="http://schema.org/Person">
  <a href="<?php echo esc_url( $github['html_url'] ); ?>" class="vcard-avatar" itemprop="image">
    <img class="avatar" data-user="<?php echo esc_attr( $github['id'] ); ?>" height="150" src="<?php echo esc_url( $github['avatar_url'] ); ?>" width="150">
  </a>

  <h1 class="vcard-names">
    <span class="vcard-fullname" itemprop="name">
      <a href="<?php echo esc_url( $github['html_url'] ); ?>"><?php echo esc_html( $github['name'] ) ?></a>
    </span>
    <span class="vcard-username" itemprop="additionalName">
      <a href="<?php echo esc_url( $github['html_url'] ); ?>"><?php echo esc_html( $github['login'] ) ?></a>
    </span>
  </h1>

  <ul class="vcard-details">
    <?php if ( ! empty( $github['company'] ) ) : ?>
    <li class="vcard-detail" itemprop="worksFor">
      <span class="octicon octicon-organization"></span>
      <?php echo esc_html( $github['company'] ) ?>
    </li>
    <?php endif; ?>

    <?php if ( ! empty( $github['location'] ) ) : ?>
    <li class="vcard-detail" itemprop="homeLocation">
      <span class="octicon octicon-location"></span>
      <?php echo esc_html( $github['location'] ) ?>
    </li>
    <?php endif; ?>

    <?php if ( ! empty( $github['email'] ) ) : ?>
    <li class="vcard-detail">
      <span class="octicon octicon-mail"></span>
      <a class="email" href="mailto:<?php echo esc_attr( $github['email'] ) ?>"><?php echo esc_html( $github['email'] ) ?></a>
    </li>
    <?php endif; ?>

    <?php if ( ! empty( $github['created_at'] ) ) : ?>
    <li class="vcard-detail">
      <span class="octicon octicon-clock"></span>
      <?php
        printf(
          __( '<span class="join-label">Joined on </span><span class="join-date">%s</span>', 'github-api' ),
          date_format( date_create( $github['created_at'] ), 'M d, Y' )
        );
      ?>
    </li>
    <?php endif; ?>
  </ul>
  <!-- / vcard-details -->

  <div class="vcard-stats">
    <a class="vcard-stat" href="<?php echo esc_url( $github['followers_url'] ); ?>">
      <?php
      printf(
        __( '<strong class="vcard-stat-count">%s</strong> followers', 'github-api' ),

        $github['followers'] > 1000
        ?
        round( $github['followers'] / 1000, 1 ) . 'k'
        :
        ( $github['followers'] ? $github['followers'] : '0' )
      );
      ?>
    </a>
    <a class="vcard-stat" href="<?php echo esc_url( $github['starred_url'] ); ?>">
      <?php
      printf(
        __( '<strong class="vcard-stat-count">%s</strong> starred', 'github-api' ),

        $github['starred'] > 1000
        ?
        round( $github['starred'] / 1000, 1 ) . 'k'
        :
        ( $github['starred'] ? $github['starred'] : '0' )
      );
      ?>
    </a>
    <a class="vcard-stat" href="<?php echo esc_url( $github['following_url'] ); ?>">
      <?php
      printf(
        '<strong class="vcard-stat-count">%s</strong> following',

        $github['following'] > 1000
        ?
        round( $github['following'] / 1000, 1 ) . 'k'
        :
        ( $github['following'] ? $github['following'] : '0' )
      );
      ?>
    </a>
  </div>
  <!-- / vcard-stats -->

  <?php if ( ! empty( $github['orgs'] ) ) : ?>
  <div class="vcard-orgs">
    <h3><?php _e( 'Organizations', 'github-api' ); ?></h3>
    <div class="avatars">
      <?php foreach ( $github['orgs'] as $o ) : ?>
      <a href="<?php echo esc_url( $o['url'] ); ?>" aria-label="<?php echo esc_attr( $o['login'] ); ?>" class="vcard-org-avatar" itemprop="follows">
        <img alt="<?php echo esc_attr( $o['login'] ); ?>" width="36" height="36" src="<?php echo esc_url( $o['avatar_url'] ); ?>" >
      </a>
      <?php endforeach; ?>
    </div>
  </div>
  <!-- / vcard-orgs -->
  <?php endif; ?>

</div>
<!-- / gh-profile-widget -->

