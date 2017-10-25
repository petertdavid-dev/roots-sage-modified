<header>
	<nav class="navbar navbar-dark py-0 bg-primary navbar-expand-lg py-md-0">
	    <div class="navbar-collapse collapse" id="havenbrandbar">
			<?php
			if ( has_nav_menu( 'primary_navigation' ) ) :
				wp_nav_menu(
					[
						'theme_location' => 'top_tabs',
						'menu_class' => 'nav navbar-nav small',
					]
				);
				endif;
			?>
		</div>
	</nav>

	<nav class="navbar navbar-expand-lg navbar-light bg-light">
	  <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>

	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#havennavbar,#havenbrandbar" aria-controls="havennavbar" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	  </button>

	  <div class="collapse navbar-collapse" id="havennavbar">
		<?php
		if ( has_nav_menu( 'primary_navigation' ) ) :
				wp_nav_menu(
					[
						'theme_location' => 'primary_navigation',
						'menu_class' => 'nav navbar-nav navbar-nav mr-auto',
					]
				);
		endif;
		?>
	  </div>
	</nav>

</header>
