<pre>
   google.language.getBranding('branding', {type: 'vertical'});
   var form = document.id('f');
       form.onsubmit = function() {
            var text = document.id('input').get('value');
                if($('results').hasChild('language')) {$('results').empty(); }
                google.language.detect(text,function(result){
                            if(!result.error) {
                                var language = 'unknown';
                                    for(var l in google.language.Languages) {
                                        if(google.language.Languages[l] == result.language) {
                                             language = l;
                                             break;
                                         } 
                                     }
                                 var div = new Element('div',{'id':'language'}).set('text','Language: ' + language).inject($('results'));
                                 var span = new Element('span').set('text',result.isReliable ? '(reliable: ' + result.confidence + ')' : '(not reliable: '+ result.confidence +')' ).inject($('results'));
                                     $('results').fade('hide');
                                     $('results').fade(1);
                                     translatedText(); 
                              } else {
                                     $('results').set('html','<span class="error">Error Detection!</span>');
                                     $('results').fade('hide');
                                     $('results').fade(1);
                              }                                                     
                });   
        return false; 
       }//end function

       function translatedText() {
            var input = document.id('input').get('value');
                 google.language.translate(input,"","en",function(result){
                        if(!result.error) {
                          $('output').set('value',result.translation); 
                          $('translated').fade('hide');
                          $('translated').fade(1);
                        } else {
                          $('output').set('value',result.error.message);        
                          $('translated').fade('hide');
                          $('translated').fade(1);
                        }
                 });
       }  
 };
 google.setOnLoadCallback(initialize);
</pre>