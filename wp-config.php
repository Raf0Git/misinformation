<?php
/**
 * Il file base di configurazione di WordPress.
 *
 * Questo file viene utilizzato, durante l’installazione, dallo script
 * di creazione di wp-config.php. Non è necessario utilizzarlo solo via web
 * puoi copiare questo file in «wp-config.php» e riempire i valori corretti.
 *
 * Questo file definisce le seguenti configurazioni:
 *
 * * Impostazioni del database
 * * Chiavi segrete
 * * Prefisso della tabella
 * * ABSPATH
 *
 * * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Impostazioni database - È possibile ottenere queste informazioni dal proprio fornitore di hosting ** //
/** Il nome del database di WordPress */
define( 'DB_NAME', 'misinformation' );

/** Nome utente del database */
define( 'DB_USER', 'root' );

/** Password del database */
define( 'DB_PASSWORD', '' );

/** Hostname del database */
define( 'DB_HOST', 'localhost' );

/** Charset del Database da utilizzare nella creazione delle tabelle. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Il tipo di collazione del database. Da non modificare se non si ha idea di cosa sia. */
define( 'DB_COLLATE', '' );

/**#@+
 * Chiavi univoche di autenticazione e di sicurezza.
 *
 * Modificarle con frasi univoche differenti!
 * È possibile generare tali chiavi utilizzando {@link https://api.wordpress.org/secret-key/1.1/salt/ servizio di chiavi-segrete di WordPress.org}
 *
 * È possibile cambiare queste chiavi in qualsiasi momento, per invalidare tutti i cookie esistenti.
 * Ciò forzerà tutti gli utenti a effettuare nuovamente l'accesso.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '9/L)e+Zs2f`35z45-}gLum)(vi(LZj0kqhx92&4U+33w`*$xn4[A}N7c;Xvb dB&' );
define( 'SECURE_AUTH_KEY',  'e6PcYxv||ZiHBvw<]Uu>A+3/)qitqnLNB8p4=BoZn|1tceHc&fAVdc7nik}L;]FU' );
define( 'LOGGED_IN_KEY',    '!}MC!n{:5Z:wSldErETzD%7 @}Lm:a:N{/M&`U+Wm*gvXPe2%^x0E|Sv=a4{T45~' );
define( 'NONCE_KEY',        '^mSk7wxav+21d%e6>+YiTcr`n(F,]av--ZW}Ue<Gtcnp9gLoQht{h[WxAY$2ganc' );
define( 'AUTH_SALT',        '7ay_Za]Ma8$h/(*KC%Jic:RVzGh,LisZwiG N^g fL;!QEQw7X,vTPR|N*FEjggT' );
define( 'SECURE_AUTH_SALT', 'N1=A%C2AOzEw!;W39~0A-1O=5bQ#x*QJ@lJNFH$+7+p:B(d;jvP_R~lK~?N<Zr7 ' );
define( 'LOGGED_IN_SALT',   'Sa`{JP5T=QAt]%T5&sLMiKz)H!N*rd9~),6?|6#=j:x`_O8z~zAV3I;a;TxWWTQY' );
define( 'NONCE_SALT',       'c`f.NR0x]^vcpdUe:GSl]E-pMXXA46cZz^H| ,]0=r2!3pmaX]P=<{d2tU$Pko6B' );

/**#@-*/

/**
 * Prefisso tabella del database WordPress.
 *
 * È possibile avere installazioni multiple su di un unico database
 * fornendo a ciascuna installazione un prefisso univoco. Solo numeri, lettere e trattini bassi!
 */
$table_prefix = 'wp_';

/**
 * Per gli sviluppatori: modalità di debug di WordPress.
 *
 * Modificare questa voce a TRUE per abilitare la visualizzazione degli avvisi durante lo sviluppo
 * È fortemente raccomandato agli svilupaptori di temi e plugin di utilizare
 * WP_DEBUG all’interno dei loro ambienti di sviluppo.
 *
 * Per informazioni sulle altre costanti che possono essere utilizzate per il debug,
 * leggi la documentazione
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Aggiungere qualsiasi valore personalizzato tra questa riga e la riga "Finito, interrompere le modifiche". */



/* Finito, interrompere le modifiche! Buona pubblicazione. */

/** Path assoluto alla directory di WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Imposta le variabili di WordPress ed include i file. */
require_once ABSPATH . 'wp-settings.php';
