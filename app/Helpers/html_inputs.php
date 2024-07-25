<?php

if ( ! function_exists( 'country_code_html_select_options' ) ) {
    function country_code_html_select_options( $from = null, $to = null )
    {
        if ( ! $from ) {
            $from = 1900;
        }

        if ( ! $to ) {
            $to = now()->year;
        }

        $years = array_reverse(range( $from, $to ));
        $html  = '';

        if ( $years ) {
            foreach ( $years as $year ) {
                $html .= "<option value='" . $year . "'>" . $year . "</option>";
            }
        }

        return $html;
    }
}
