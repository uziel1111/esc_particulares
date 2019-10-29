$("#btn_prueba").click(function(e){
      e.preventDefault();

      $.ajax({
            url:base_url+"/Inicio/mensaje",
            data: {"msj": "hola"
                },
            type:"POST",
            beforeSend: function(xhr) {
              $("#wait").modal("show");
            },
            success:function(data){
              $("#wait").modal("hide");
              // var datax = JSON.parse(data);
              console.log(data);
              $("#inp_text_pruebas").val(data.result);


            },
            error: function(jqXHR, textStatus, errorThrown){
        			$("#wait").modal("hide");
              alert("error")
        		}
          });

  });
