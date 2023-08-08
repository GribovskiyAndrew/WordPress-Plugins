<?php
/*
	Plugin Name: Microdata Plugin
	Description: Microdata Plugin
	Version: 1.0
	Author: Andriy
	*/

function insert_medical_business_md()
{

    $content = '<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "MedicalBusiness",
  "name": "CaliforniaHRTClinic",
  "description": "Unlock your potential at California HRT Clinic through safe and legal HGH and Testosterone Therapy and experience a new level of vitality and wellness",
  "logo": "https://califoriahrtclinic.com/wp-content/uploads/2023/05/cropped-california-hrt-logo.png",
  "email": "info@califoriahrtclinic.com",
  "areaServed": {
    "@type": "AdministrativeArea",
    "name": "California"
  },
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "2570 North 1st Street",
    "addressLocality": "San Jose",
    "addressRegion": "California",
    "postalCode": "95131"
  },
  "openingHours": "Mo-Fr 09:00-22:00; Sa-Su 09:00-20:00"
}
</script>
';

    return $content;
}

add_shortcode('insert_medical_business', 'insert_medical_business_md');

function insert_md_administrative_area($content)
{

    $parent_page_id = wp_get_post_parent_id(get_the_ID());

    if ($parent_page_id == 25517) {

        $tags = get_the_tags();

        if (count($tags) == 1) {

            $page_title = get_the_title();

            $script = '<script type="application/ld+json"> {
  "@context": "https://schema.org",
  "@type": "MedicalBusiness",
  "name": "HGH therapy",
  "alternateName": "Testosterone therapy",
  "sameAs": [
    "https://twitter.com/ClinicHrt43791",
    "https://www.facebook.com/people/California-HRT-Clinic/100093951595394/"
  ],
  "logo": "https://califoriahrtclinic.com/wp-content/uploads/2023/05/cropped-california-hrt-logo.png",
  "areaServed": {
    "@type": "AdministrativeArea",
    "name": " ' . $page_title . '"
  },
  "openingHours": "Mo-Fr 09:00-22:00; Sa-Su 09:00-20:00"
}</script>';
        }

        $content = $script . $content;
    }

    return $content;
}

add_filter('the_content', 'insert_md_administrative_area');
