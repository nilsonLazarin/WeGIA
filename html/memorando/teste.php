<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>teste</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="teste.css">
    <script>

(function ($) {
        $.fn.uploader = function (options) {
            var settings = $.extend(
            {
                // MessageAreaText: "No files selected.",
                // MessageAreaTextWithFiles: "File List:",
                // DefaultErrorMessage: "Unable to open this file.",
                // BadTypeErrorMessage: "We cannot accept this file type at this time.",
                acceptedFileTypes: [
                "pdf",
                "php",
                "odt",
                "jpg",
                "gif",
                "jpeg",
                "bmp",
                "tif",
                "tiff",
                "png",
                "xps",
                "doc",
                "docx",
                "fax",
                "wmp",
                "ico",
                "txt",
                "cs",
                "rtf",
                "xls",
                "xlsx"
                ]
            },
            options
            );

            var uploadId = 1;
            //update the messaging
            //atualiza a mensagem
            $(".file-uploader__message-area p").text(
            options.MessageAreaText || settings.MessageAreaText
            );

            //create and add the file list and the hidden input list
            // cria e adiciona a lista de arquivos e a lista de entrada oculta
            var fileList = $('<ul class="file-list"></ul>');
            var hiddenInputs = $('<div class="hidden-inputs hidden"></div>');
            $(".file-uploader__message-area").after(fileList);
            $(".file-list").after(hiddenInputs);

            //when choosing a file, add the name to the list and copy the file input into the hidden inputs
            //ao escolher um arquivo, adicione o nome à lista e copie a entrada do arquivo para as entradas ocultas
            $(".file-chooser__input").on("change", function () {
            var files = document.querySelector(".file-chooser__input").files;

            for (var i = 0; i < files.length; i++) {
                console.log(files[i]);

                var file = files[i];
                // console.log(file);
                var fileName = file.name.match(/([^\\\/]+)$/)[0];

                //clear any error condition
                //limpe qualquer condição de erro
                $(".file-chooser").removeClass("error");
                $(".error-message").remove();

                //validate the file
                //valide o arquivo

                var check = checkFile(fileName);
                if (check === "valid") {
                // move the 'real' one to hidden list
                //mova o 'real' para a lista oculta
                
                
                $(".hidden-inputs").append($(".file-chooser__input")); 
                
                //importante


                //insert a clone after the hiddens (copy the event handlers too)
                //insira um clone após os hiddens (copie os manipuladores de eventos também)

                $(".file-chooser").append(
                    $(".file-chooser__input").clone({ withDataAndEvents: true })
                );

                //add the name and a remove button to the file-list
                //adicione o nome e um botão de remoção à lista de arquivos
                $(".file-list").append(
                    '<li style="display: none;"><span class="file-list__name">' +
                    fileName +
                    '</span><button class="removal-button" data-uploadid="' +
                    uploadId +
                    '"></button></li>'
                );
                $(".file-list").find("li:last").show(800);

                //removal button handler
                //manipulador de botão de remoção
                $(".removal-button").on("click", function (e) {
                    e.preventDefault();

                    //remove the corresponding hidden input
                    //remove a entrada oculta correspondente
                    $(
                    '.hidden-inputs input[data-uploadid="' +
                        $(this).data("uploadid") +
                        '"]'
                    ).remove();

                    //remove the name from file-list that corresponds to the button clicked
                    //remova o nome da lista de arquivos que corresponde ao botão clicado
                    $(this)
                    .parent()
                    .hide("puff")
                    .delay(10)
                    .queue(function () {
                        $(this).remove();
                    });

                    //if the list is now empty, change the text back
                    //se a lista estiver vazia, mude o texto de volta
                    if ($(".file-list li").length === 0) {
                    $(".file-uploader__message-area").text(
                        options.MessageAreaText || settings.MessageAreaText
                    );
                    }
                });

                //so the event handler works on the new "real" one
                //então o manipulador de eventos funciona no novo "real"
                $(".hidden-inputs .file-chooser__input")
                    .removeClass("file-chooser__input")
                    .attr("data-uploadId", uploadId);

                //update the message area
                //atualize a área de mensagem
                $(".file-uploader__message-area").text(
                    options.MessageAreaTextWithFiles ||
                    settings.MessageAreaTextWithFiles
                );

                uploadId++;
                } else {
                //indicate that the file is not ok
                //indica que o arquivo não está ok
                $(".file-chooser").addClass("error");
                var errorText =
                    options.DefaultErrorMessage || settings.DefaultErrorMessage;

                if (check === "badFileName") {
                    errorText =
                    options.BadTypeErrorMessage || settings.BadTypeErrorMessage;
                }

                $(".file-chooser__input").after(
                    '<p class="error-message">' + errorText + "</p>"
                );
                }
            }


            });


            var checkFile = function (fileName) {
            var accepted = "invalid",
                acceptedFileTypes =
                this.acceptedFileTypes || settings.acceptedFileTypes,
                regex;

            for (var i = 0; i < acceptedFileTypes.length; i++) {
                regex = new RegExp("\\." + acceptedFileTypes[i] + "$", "i");

                if (regex.test(fileName)) {
                accepted = "valid";
                break;
                } else {
                accepted = "badFileName";
                }
            }

            return accepted;

            };
  
        };        

        })($);

        //init
        $(document).ready(function () {
        console.log("hi");
        $(".fileUploader").uploader({
            MessageAreaText: "No files selected. Please select a file."
        });
        });

    </script>
    <style>

.hidden {
    display: none;
    /* & input {
      display: none;
    } */
  }
    </style>

</head>
<body>
    <form method="post" class="file-uploader" action="teste_envio.php" enctype="multipart/form-data">
        <div class="file-uploader__message-area">
            <p>Select a file to upload</p>
        </div>
        <div class="file-chooser">
            <input type="file" multiple name='arquivos[]' class="file-chooser__input" >
        </div>
        <input class="file-uploader__submit-button" type="submit" value="Upload">
    </form>
</body>
</html>