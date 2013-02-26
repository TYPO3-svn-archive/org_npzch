/**
 *
 * Skript für das automatiche Blättern von Tab zu Tab im TYPO3-Browser-Plugin
 * Copyright (c) 2011 Dirk Wildt, http://wildt.at.die-netzmacher.de/
 *
 * BE AWARE: You have to enable Rotate Views in your Browser flexform.
 * Else jQuery won't included probably: than you will get JSS errors!
 * 
 */

$( document ).ready( function( )
{
  var curLoop   = 0;          // Anzahl bisheriger Durchläufe
  var maxLoops  = 620;        // Maximale Anzahl von Durchläufen für das Blättern (gut einen Tag lang)
  var first_tab = 60 * 1000;  // Zeige den ersten Tab 60 Sekunden lang
  var other_tab = 20 * 1000;  // Zeige alle anderen Tabs 20 Sekunden lang

    // Funktion: Autmatisches Durchblättern der Tabs
  function loop_tabs( )
  {
      // Beende das Durchblättern nach maxLoops Durchläufen
    if( curLoop >= maxLoops )
    {
      if( t3browserAlert )
      {
        alert(  "Die maximale Anzahl von " + maxLoops + " Durchläufen ist erreicht.\n" +
                "\n" +
                "Wenn die Tabs länger automatisch wechseln sollen, erhöhe bitte den Wert von maxLoops.\n" +
                "maxLoops hat jetzt den Wert: " + maxLoops + ".\n" +
                "Das Javascript befindet sich im TYPO3-Backend auf dieser Seite."
              );
      }
      return;
    }
      // Beende das Durchblättern nach maxLoops Durchläufen

      // Blätter zum nächsten Tab
    setTimeout( function( )
    {
        // ABBRUCH: FEHLER. Tab (Id) ist nicht vorhanden
      if( ! $( "#c###TT_CONTENT.UID###-list-tab-11081302" ).length )
      {
        if( t3browserAlert )
        {
          alert(  "FEHLER: Der Tab mit der Id #c###TT_CONTENT.UID###-list-tab-11081302 ist nicht vorhanden.\n" +
                  "\n" +
                  "Das kannst Du tun:\n" +
                  "* Diese Seite im TYPO3-Backend enthält ein Javascript.\n" +
                  "* Prüfe in dem Skript bitte die Variable ###TT_CONTENT.UID###.\n" +
                  "  ###TT_CONTENT.UID### hat jetzt den Wert ###TT_CONTENT.UID###.\n" +
                  "  ###TT_CONTENT.UID### muss den Wert der Id des Browser-Plugins haben.\n" +
                  "* Die andere Nummer im Tab ist die Id der View im TypoScript.\n" +
                  "  Die View bzw. die Id muss im TypoScript vorhanden sein."
              );
        }
        return;
      }
        // ABBRUCH: FEHLER. Tab (Id) ist nicht vorhanden

      $( "#c###TT_CONTENT.UID###-list-tab-11081302" ).trigger( 'click' )
      setTimeout( function( )
      {
        $( "#c###TT_CONTENT.UID###-list-tab-11081303" ).trigger( 'click' )
        setTimeout( function( )
        {
          $( "#c###TT_CONTENT.UID###-list-tab-11081304" ).trigger( 'click' )
          setTimeout( function( )
          {
            $( "#c###TT_CONTENT.UID###-list-tab-11081305" ).trigger( 'click' )
            setTimeout( function( )
            {
              $( "#c###TT_CONTENT.UID###-list-tab-11081301" ).trigger( 'click' )
                // Call the loop recursive
              loop_tabs( );
            }, other_tab );
          }, other_tab );
        }, other_tab );
      }, other_tab );
    }, first_tab );
      // Blätter zum nächsten Tab
    curLoop++;
  }
    // Funktion: Autmatisches Durchblättern der Tabs

    // Starte mit automatischen Durchblättern der Tabs nach 90 Sekunden
  setTimeout( function( )
  {
    loop_tabs( );
  }, 90 * 1000 ); // 90 Sekunden
});
