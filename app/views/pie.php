<div class="cleaner"></div>
</div>
<div id="templatemo_main_bottom"></div>
   <div id="footer_arst">
       &nbsp;<br/><br/><br/>
    </div>
    <div id="footer_grass">
        &nbsp;
    </div>
    <!-- footer -->
    <div id="footer">
            <div id="footnotes">
                <p style="float:left;">
 		<b>Recuper@</b> es software libre con 
		<a href="http://www.gnu.org/licenses/agpl-3.0.html">Licencia Affero</a><br />
		 Visita la <a href="http://recupera.org.es" target="_blank">web del proyecto</a>
			-
		 Accede al <a href="https://github.com/vtellez/recupera" target="_blank">código fuente</a>
                </p>
                <p style="float:right; text-align:right;">
		<a href="http://www.us.es/" target="_blank">Universidad de Sevilla</a><br/>
                <a href="http://www.us.es/campus/servicios/sic/" target="_blank">Servicio de Informática y Comunicaciones</a><br/>
                </p>
		<br/><br/><br/>
		<p style="left-margin:200px;"><small>Universidad de Sevilla. C/ S. Fernando, 4, C.P. 41004-Sevilla, España. Centralita exterior: 954551000</small></p>
            </div>
        </div>
    </div>


<script type="text/javascript">
$(function() {
        $( "input:submit" ).button();
        $( "button" ).button();
        
        //º$('#templatemo_header').hide();
        
        //Back to top function
        $(window).scroll(function() {
                if($(this).scrollTop() != 0) {
                        $('#toTop').fadeIn();   
                } else {
                        $('#toTop').fadeOut();
                }
        });
 
        $('#toTop').click(function() {
                $('body,html').animate({scrollTop:0},600);
        });   
        //Dialog
        $('#dialog').dialog({
                autoOpen: false,
                width: 700,
                buttons: [{ 
                           text:"Si, cerrar la sesión", 
                                click:function() { 
                                                window.location.href = '<?php echo site_url("logout");?>';
                                                return false;
                                                        }
                                },
                                {
                                        text:"Cancelar",
                                        click: function() { 
                                                        $(this).dialog("close"); 
                                        }
                                } 
                        ],
                 modal: true
          });

         // Dialog Link
         $('#dialog_link').click(function(){
                $('#dialog').dialog('open');
                return false;
         });
});
</script>
</body>
</html>
