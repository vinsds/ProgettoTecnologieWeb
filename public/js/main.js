/**
 * Created by vincenzodisciullo on 18/10/15.
 */
var flag = true;
var flagTel = true;
var flagUser = true;
var menuFlag = true;
var searchFlag = true;
var editFlag = true;
$(document).ready(function () {
    $(".box-collapse .faq-title").click(function(){
        $(this).parent().find(".txt-desc").slideToggle("fast");
    });

    initAdminParams();
    faq();
    editFaq();
    centro();
    //setModalAlert();

    initSearchFilter();
    initProductList();
    initModal();
    loginForm();
    getValueMalf();
    initBarUser();
    initBottomBar();
    initMalf();

    openModalWindowLoad();

    insertFormCheckField_Malfunzionamento_Soluzione();
    initFormProfilo();

    initFormProdottoCreate();
    initFormProdottoEdit();
    initFormComponenteCreate();
    initFormComponentEdit();
    //initAddMalf();

    //TEST FUNCTIONS
    initParam();
    searchInit();
    //formControlField();
});

function initAdminParams(){
    $(".admin-faq i.fa-pencil").click(function(){
        var id=$(this).parent().parent().attr("value");
        $(this).parent().parent().attr("href",baseUrl+"/faq/edit/id/"+id);
    });

    $(".admin-faq i.fa-trash").click(function(){
        var id=$(this).parent().parent().attr("value");
        if (confirm("Sicuro di voler rimuovere la faq selezionata?")) {
            $(this).parent().parent().attr("href",baseUrl+"/faq/delete/id/"+id);
        }
    });

    $(".admin-user i.fa-pencil").click(function(){
        var id=$(this).parent().parent().attr("value");
        $(this).parent().parent().attr("href",baseUrl+"/admin/modifica/id/"+id);
    });

    $(".admin-user i.fa-trash").click(function(){
        var id=$(this).parent().parent().attr("value");
        if (confirm("Sicuro di voler rimuovere l'utente selezionato?")) {
            $(this).parent().parent().attr("href",baseUrl+"/admin/delete/id/"+id);
        }
    });

    $(".admin-centro .tab-element:nth-child(4)").click(function(){
        var id=$(this).parent().attr("value");
        $(this).parent().attr("href",baseUrl+"/centro/modifica/id/"+id);
    });

    $(".admin-centro .tab-element:nth-child(5)").click(function(){
        var id=$(this).parent().attr("value");
        if (confirm("Sicuro di voler rimuovere il centro selezionato?")) {
            $(this).parent().attr("href",baseUrl+"/centro/delete/id/"+id);
        }
    });

    $(".admin-product .tab-element:nth-child(5)").click(function(){
        var id=$(this).parent().attr("value");
        if (confirm("Sicuro di voler rimuovere il prodotto selezionato?")) {
            $(this).parent().attr("href",baseUrl+"/admin/deleteproduct/id/"+id);
        }
    });

    $(".admin-product .tab-element:nth-child(4)").click(function(){
        var id=$(this).parent().attr("value");
        $(this).parent().attr("href",baseUrl+"/admin/editproduct/id/"+id);
    });

    $(".admin-product-assoc").click(function(){
        var id=$(this).attr("value");
        action_ajax=baseUrl+"/admin/findcomponent";
        ajaxassociazioneprodcomp(id,action_ajax);
        var txt=$(this).find(".tab-element:nth-child(2)").html();
        $("#modal-change-box-content span").html(txt);
        $("#modal-change-box-content span").attr("value",id);
        $("#modal-change-box").fadeIn("fast");
    });

    $(".admin-component .tab-element:nth-child(4)").click(function(){
        var id=$(this).parent().attr("value");
            $(this).parent().attr("href",baseUrl+"/admin/editcomponente/id/"+id);
    });

    $(".admin-component .tab-element:nth-child(5)").click(function(){
        var id=$(this).parent().attr("value");
        $(this).parent().attr("href",baseUrl+"/admin/deletecomponent/id/"+id);
    });

    $(".admin-cat .tab-element:nth-child(4)").click(function(){
        var id=$(this).parent().attr("value");
        if (confirm("Sicuro di voler rimuovere la categoria selezionata?")) {
            $(this).parent().attr("href",baseUrl+"/categoria/deletecat/id/"+id);
        }
    });

    $(".admin-cat .tab-element:nth-child(3)").click(function(){
        var id=$(this).parent().attr("value");
            $(this).parent().attr("href",baseUrl+"/categoria/editcategoria/id/"+id);
    });


    $(".admin-sub-cat .tab-element:nth-child(4)").click(function(){
        var id=$(this).parent().attr("value");
        if (confirm("Sicuro di voler rimuovere la sottocategoria selezionata?")) {
            $(this).parent().attr("href",baseUrl+"/categoria/deletesubcat/id/"+id);
        }
    });

    $(".admin-sub-cat .tab-element:nth-child(3)").click(function(){
        var id=$(this).parent().attr("value");
        $(this).parent().attr("href",baseUrl+"/categoria/editsottocategoria/id/"+id);
    });
}

/***
 * Controlla i campi della form per l'inserimento dei malfunzionamenti e soluzioni.
 * Se i campi sono validi è possibile effettuare la submit, altrimenti viene comunicato l'errore
 */
function insertFormCheckField_Malfunzionamento_Soluzione(){
    var txt="";
    $("form").mouseenter(function(){
        var id=$(this).attr("id");
        if(id=='createMalfunzionamento' || id=='createSoluzione' || id=='editMalfunzionamento' || id=='editSoluzione'){
            //$("form input[type=submit]").attr("disabled","disabled");
            $("form#"+id+" input[type=text]").focusout(function(){
                txt=$(this).val();
                var len=txt.length;
                if(len==0){
                    $("#modal-alert h3.msg").html("il campo 'Nome', non può essere vuoto");
                    $(this).addClass("wrongField");
                    //$("form#"+id+" input[type=submit]").attr("disabled","disabled");
                    $(this).attr("value","");
                }else if(len > 1 && len < 25){
                    $("#modal-alert h3.msg").html("");
                    $(this).addClass("correctField").removeClass("wrongField");
                    //$("form#"+id+" input[type=submit]").removeAttr("disabled");
                }else if(len > 25){
                    $("#modal-alert h3.msg").html("Il nome non può superare i 25 caratteri.");
                    $(this).addClass("wrongField");
                }
            });
            $("form#"+id+" textarea").focusout(function(){
                txt=$(this).val();
                var len=txt.length;
                if(len==0){
                    $("#modal-alert h3.msg").html("il campo 'Descrizione', non può essere vuoto");
                    $(this).addClass("wrongField");
                    //$("form#"+id+" input[type=submit]").attr("disabled","disabled");
                    $(this).attr("value","");
                }else if(len > 1 && len < 160){
                    $("#modal-alert h3.msg").html("");
                    $(this).addClass("correctField").removeClass("wrongField");
                    //$("form#"+id+" input[type=submit]").removeAttr("disabled");
                }else if(len > 160){
                    $("#modal-alert h3.msg").html("Descrizione troppa lunga, non deve superare i 160 caratteri");
                    $(this).addClass("wrongField");
                }
            });
        }
    });
}


/**
 * AJAX per popolare le select delle sottocategorie
 */
function ajaxsubcat(id,url){
    $.ajax({
        type: "POST",
        url: url,
        data: {"id": id},
        dataType: "JSON",
        success: function (data) {
            $("select#id_sottocategoria").html("<option selected value='0'>scegli sottocategoria</option>");
            var i;
            setTimeout(function(){
                for(i=0; i<data.length; i++){
                    $("select#id_sottocategoria").append('<option value='+data[i]['id_sottocategoria']+'>'+data[i]['nome']+'</option>');
                }
            },50);
        },
        error: function () {
            alert("Inserire un pop up di errore");
        }
    });
}
/**
 *Funzione per il controllo della form prodotto
 */
function initFormProdottoCreate(){
    var
        categoria=0,
        sottocategoria=0,
        nome="",
        descrizione="",
        istruzioni="",
        note="",
        data;

    $("select#id_categoria").change(function(){
        $( "select option:selected").unbind("click").click(function() {
            categoria=$(this).attr("value");
            ajaxsubcat(categoria,baseUrl+"/admin/subcat");
        });
    });

    $("select#id_sottocategoria").change(function(){
        $( "select option:selected").unbind("click").click(function() {
           sottocategoria=$(this).attr("value");
        });
    });

    $("form#createprodotto input[type=text]").focusout(function() {
        var id = $(this).attr("id");
        switch (id) {
            case 'nome':
                nome = $(this).val();
                checkField(nome, $(this), "nome");
                break;
        }
    });

    $("form#createprodotto textarea").focusout(function(){
        var id=$(this).attr("id");
        switch (id) {
            case 'desc_prod':
                descrizione = $(this).val();
                checkField(descrizione,$(this),"descrizione");
                break;
            case 'istruzioni':
                istruzioni = $(this).val();
                checkField(istruzioni,$(this),"istruzioni");
                break;
            case 'note':
                note = $(this).val();
                checkField(note,$(this),"note");
                break;
        }
    });

    $("form#createprodotto input[type=submit]").click(function(e) {
        data=[nome,descrizione,istruzioni];
        if(activeSubmit(data)){
            e.submit
        }else{
            e.preventDefault();
        }
    });
}

function initFormComponenteCreate(){
    var
        sottocategoria=0,
        nome="",
        descrizione="",
        istruzioni="",
        note="";

    //$("select#id_categoria").change(function(){
    //    $( "select option:selected").unbind("click").click(function() {
    //        categoria=$(this).attr("value");
    //        ajaxsubcat(categoria,baseUrl+"/admin/subcat");
    //    });
    //});

    $("select#id_sottocategoria").change(function(){
        $( "select option:selected").unbind("click").click(function() {
            sottocategoria=$(this).attr("value");
        });
    });

    $("form#createcomponente input[type=text]#nome").focusout(function(){
        nome=$(this).val();
        if(nome==""){
            $("form#createcomponente input[type=text]#nome").addClass("wrongField");
            $("#form-msg p.wrong-insert").html("Il campo nome non può essere vuoto");
        }else{
            $(this).removeClass("wrongField").addClass("correctField");
        }
    });

    $("form#createcomponente textarea#desc_comp").focusout(function(){
        descrizione=$(this).val();
        if(descrizione==""){
            $("form#createcomponente textarea#desc_comp").addClass("wrongField");
            $("#form-msg p.wrong-insert").html("Il campo descrizione non può essere vuoto");
        }else{
            $(this).removeClass("wrongField").addClass("correctField");
        }
    });

    $("form#createcomponente textarea#istruzioni").focusout(function(){
        istruzioni=$(this).val();
        if(istruzioni==""){
            $("form#createcomponente textarea#istruzioni").addClass("wrongField");
            $("#form-msg p.wrong-insert").html("Il campo descrizione non può essere vuoto");
        }else{
            $(this).removeClass("wrongField").addClass("correctField");
        }
    });

    $("form#createcomponente textarea#note").focusout(function(){
        note=$(this).val();
        if(note==""){
            $("form#createcomponente textarea#note").addClass("wrongField");
            $("#form-msg p.wrong-insert").html("Il campo note non può essere vuoto");
        }else{
            $(this).removeClass("wrongField").addClass("correctField");
        }
    });

    $("form#createcomponente input[type=submit]#submitcomponente").click(function(e){
        if(sottocategoria==0) {
            e.preventDefault();
        }
        if(nome==""){
            e.preventDefault();
        }
        if(descrizione=="") {
            e.preventDefault();
        }
        if(istruzioni=="") {
            e.preventDefault();
        }

        if(note==""){
            e.preventDefault();
        }

        if(categoria!=0 && sottocategoria!=0 && nome!="" && descrizione!="" && istruzioni!="" && note!=""){
            $("#form-msg p.wrong-insert").html("");
            e.submit;
        }
    });
}
//
function initFormProdottoEdit(){
    var
        nome=$("form#modificaprodotto input[type=text]#nome").val(),
        descrizione=$("form#modificaprodotto textarea#desc_prod").val(),
        istruzioni=$("form#modificaprodotto textarea#istruzioni").val(),
        categoria=$("select#id_categoria").val(),
        sottocategoria=$("select#id_sottocategoria").attr("value"),
        note=$("form#modificaprodotto textarea#note").attr("value");


    $("select#id_categoria").change(function(){
        $( "select option:selected").unbind("click").click(function() {
            categoria=$(this).attr("value");
            ajaxsubcat(categoria,baseUrl+"/admin/subcat");
        });
    });

    $("select#id_sottocategoria").change(function(){
        $( "select option:selected").unbind("click").click(function() {
            sottocategoria=$(this).attr("value");
        });
    });

    $("form#modificaprodotto input[type=text]#nome").focusout(function(){
        nome=$(this).val();
        if(nome==""){
            $("form#modificaprodotto input[type=text]#nome").addClass("wrongField");
            $("#form-msg p.wrong-insert").html("Il campo nome non può essere vuoto");
        }else{
            $(this).removeClass("wrongField").addClass("correctField");
        }
    });

    $("form#modificaprodotto textarea#desc_prod").focusout(function(){
        descrizione=$(this).val();
        if(descrizione==""){
            $("form#modificaprodotto textarea#desc_prod").addClass("wrongField");
            $("#form-msg p.wrong-insert").html("Il campo descrizione non può essere vuoto");
        }else{
            $(this).removeClass("wrongField").addClass("correctField");
        }
    });

    $("form#modificaprodotto textarea#istruzioni").focusout(function(){
        istruzioni=$(this).val();
        if(istruzioni==""){
            $("form#modificaprodotto textarea#istruzioni").addClass("wrongField");
            $("#form-msg p.wrong-insert").html("Il campo istruzioni non può essere vuoto");
        }else{
            $(this).removeClass("wrongField").addClass("correctField");
        }
    });

    $("form#modificaprodotto textarea#note").focusout(function(){
        istruzioni=$(this).val();
        if(istruzioni==""){
            $("form#modificaprodotto textarea#note").addClass("wrongField");
            $("#form-msg p.wrong-insert").html("Il campo note non può essere vuoto");
        }else{
            $(this).removeClass("wrongField").addClass("correctField");
        }
    });

    $("form#modificaprodotto input[type=submit]#submiteditprodotto").click(function(e){
        if(nome==""){
            e.preventDefault();
        }

        if(descrizione=="") {
            e.preventDefault();
        }
        if(istruzioni=="") {
            e.preventDefault();
        }

        if(note=="") {
            e.preventDefault();
        }

        if(nome!="" && descrizione!="" && istruzioni!="" && note!=""){
            //alert("INVIO");
            e.submit;
        }

    });
}

function initFormComponentEdit(){
    var
        nome=$("form#modificacomponente input[type=text]#nome").val(),
        descrizione=$("form#modificacomponente textarea#desc_prod").val(),
        istruzioni=$("form#modificacomponente textarea#istruzioni").val(),
        categoria=$("select#id_categoria").val(),
        sottocategoria=$("select#id_sottocategoria").attr("value"),
        note=$("form#modificacomponente textarea#note").attr("value");


    $("select#id_categoria").change(function(){
        $( "select option:selected").unbind("click").click(function() {
            categoria=$(this).attr("value");
            ajaxsubcat(categoria,baseUrl+"/admin/subcat");
        });
    });

    $("select#id_sottocategoria").change(function(){
        $( "select option:selected").unbind("click").click(function() {
            sottocategoria=$(this).attr("value");
        });
    });

    $("form#modificacomponente input[type=text]#nome").focusout(function(){
        nome=$(this).val();
        if(nome==""){
            $("form#modificacomponente input[type=text]#nome").addClass("wrongField");
            $("#form-msg p.wrong-insert").html("Il campo nome non può essere vuoto");
        }else{
            $(this).removeClass("wrongField").addClass("correctField");
        }
    });

    $("form#modificacomponente textarea#desc_comp").focusout(function(){
        descrizione=$(this).val();
        if(descrizione==""){
            $("form#modificacomponente textarea#desc_comp").addClass("wrongField");
            $("#form-msg p.wrong-insert").html("Il campo descrizione non può essere vuoto");
        }else{
            $(this).removeClass("wrongField").addClass("correctField");
        }
    });

    $("form#modificacomponente textarea#istruzioni").focusout(function(){
        istruzioni=$(this).val();
        if(istruzioni==""){
            $("form#modificacomponente textarea#istruzioni").addClass("wrongField");
            $("#form-msg p.wrong-insert").html("Il campo istruzioni non può essere vuoto");
        }else{
            $(this).removeClass("wrongField").addClass("correctField");
        }
    });

    $("form#modificacomponente textarea#note").focusout(function(){
        istruzioni=$(this).val();
        if(istruzioni==""){
            $("form#modificacomponente textarea#note").addClass("wrongField");
            $("#form-msg p.wrong-insert").html("Il campo note non può essere vuoto");
        }else{
            $(this).removeClass("wrongField").addClass("correctField");
        }
    });

    $("form#modificacomponente input[type=submit]#submiteditcomponente").click(function(e){
        if(nome==""){
            e.preventDefault();
        }

        if(descrizione=="") {
            e.preventDefault();
        }
        if(istruzioni=="") {
            e.preventDefault();
        }

        if(note=="") {
            e.preventDefault();
        }

        if(nome!="" && descrizione!="" && istruzioni!="" && note!=""){
            //alert("INVIO");
            e.submit;
        }

    });
}
/**
 * Funzione per il controllo della form "profilo"
 */

function initFormProfilo(){
    $("form").mouseenter(function(){
        var id=$(this).attr("id");
        if(id=='modificaprofilo' || id=='createutente' || id=='editutente'){

            $("form#"+id+" input[type=text]").focusin(function(){
                $("#form-msg p.correct-insert").html("");
            var inputId=$(this).attr("id");
                if(inputId=='password'){
                    $("#form-msg p.correct-insert").html("Inserire una password che contenga:<br />" +
                        "un carattere maiuscolo;<br/>un carattere minuscolo;<br />numeri;");
                }
            });

            $("form#"+id+" input[type=text]").focusout(function(){
                var inputId=$(this).attr("id");
                var txt=$(this).val();
                var len=txt.length;
                if(inputId=='nascita') {
                    validateDate(txt,$(this));
                }else if(inputId=='password'){
                    if(len==0){
                        $(this).addClass("wrongField");
                        $("#form-msg p.wrong-insert").html("Il campo non può essere vuoto");
                    }else if(len>2){
                        $(this).addClass("correctField").removeClass("wrongField");
                        $("#form-msg p.wrong-insert").html("");

                    }else if(len > 25 || len < 4){
                        $(this).addClass("wrongField");
                        $("#form-msg p.wrong-insert").html("Min char 3 - Max char 25");
                    }
                }
                else{

                    if(len==0){
                        $(this).addClass("wrongField");
                        $("#form-msg p.wrong-insert").html("Il campo non può essere vuoto");
                    }else if(len > 3 && len < 25){
                        $(this).addClass("correctField").removeClass("wrongField");
                        $("#form-msg p.wrong-insert").html("");
                    }else if(len > 25){
                        $(this).addClass("wrongField");
                        $("#form-msg p.wrong-insert").html("Il campo deve contenere 25 caratteri");
                    }
                }

                if(inputId=='email'){
                    validateMail(txt,$(this));
                }

            });
        }
    });
}


$(window).resize(function () {
    initParam();
});

$(window).load(function(){
    initLoad();
});

function initLoad(){

    setTimeout(function(){
        if($("#form-insert-faq").hasClass("insert")){
            $(".title-page").append("<h2>Stai per essere reinderizzato alla lista delle faq</h2>");
            $("#form-insert-faq").hide();
        }

        if($("#form-edit-faq").hasClass("edit-on")){
            $(".title-page").append("<h2>Stai per essere reinderizzato alla lista delle faq</h2>");
            $("#form-edit-faq").hide();
        }

        if($(".title-page").hasClass("delete-on")){
            $(".title-page").append("<h2>Stai per essere reinderizzato alla lista dei centri</h2>");
        }

        if($(".title-page").hasClass("add-centro")){
            $(".title-page").append("<h2>Stai per essere reinderizzato alla lista dei centri</h2>");
        }

        if($("#modifica-centro").hasClass("edit-centro-on")){
            $(".title-page").append("<h2>Stai per essere reinderizzato alla lista dei centri</h2>");
            $("#modifica-centro form").fadeOut("fast");
        }

        if($("#form-add-user").hasClass("add-user-on")){
            $(".title-page").append("<h2>Stai per essere reinderizzato alla lista degli utenti</h2>");
            $("#form-add-use form").fadeOut("fast");
        }

        if($(".title-page").hasClass("add-faq-on")){
            $(".title-page").append("<h2>Stai per essere reinderizzato alla lista delle faq</h2>");
        }

    },50);


    if($("#form-insert-faq").hasClass("insert")) {
        setTimeout(function () {
            window.location = (baseUrl + "/faq/faqlist");
        }, 2500);
    }

    if($("#form-edit-faq").hasClass("edit-on")) {
        setTimeout(function () {
            window.location = (baseUrl + "/faq/faqlist");
        }, 2500);
    }

    if($(".title-page").hasClass("delete-on")) {
        setTimeout(function () {
            window.location = (baseUrl + "/centro/centrilist");
        }, 2500);
    }

    if($(".title-page").hasClass("add-centro")) {
        setTimeout(function () {
            window.location = (baseUrl + "/centro/centrilist");
        }, 2500);
    }

    if($("#modifica-centro").hasClass("edit-centro-on")) {
        setTimeout(function () {
            window.location = (baseUrl + "/centro/centrilist");
        }, 2500);
    }

    if($("#form-add-user").hasClass("add-user-on")) {
        setTimeout(function () {
            window.location = (baseUrl + "/admin/userlist");
        }, 2500);
    }

    if($(".title-page").hasClass("add-faq-on")) {
        setTimeout(function () {
            window.location = (baseUrl + "/faq/faqlist");
        }, 2500);
    }

}

function openModalWindowLoad() {
    setTimeout(function () {
        if ($("#modal-alert").hasClass("crud")) {
            $("#modal-box").fadeIn("fast");
            $("#modal-alert").fadeIn("fast");
        }
    }, 100);
}


function searchInit() {

    $(".search").click(function () {
        if (searchFlag) {

            $("html").css("overflow","hidden");

            //$("#modal-box").fadeOut("fast");
            $("#modal-change-box").fadeOut("fast");
            $(".popup-bg.find").fadeIn("fast");
            $(this).css("background", "white");
            $(this).find("i.fa").css("color", "rgba(3,169,244,1)");
            $(".menu i.fa").removeAttr("style");
            $(".menu").removeAttr("style");
            $(".popup-bg.menu-item").fadeOut("fast");
            userBtnIntit();
            setTimeout(function () {
                searchFlag = false;
            }, 200);
        } else {
            $("html").removeAttr("style");
            $(".popup-bg.find").fadeOut("fast");
            $(this).removeAttr("style")
            $(this).find("i.fa").removeAttr("style");
            setTimeout(function () {
                searchFlag = true;
            }, 200);
        }

    });

    //$(".popup-bg").click(function(){
    //    $(this).fadeOut("fast");
    //});
    $(".popup-bg.find i.fa-times").click(function () {
        $(".popup-bg").fadeOut("fast");
        $(".search").removeAttr("style");
        $(".search i.fa").removeAttr("style");
        $("html").removeAttr("style");

    });
}

function test() {
    $(".items .box-item").click(function (e) {
        e.preventDefault();
        var a = $(this).find(".product-name").text();
        setTimeout(function () {
            $("ul.item-selected").append("<li><a href='#'>" + a + "</a></li>");
        }, 500);
    });
}

function initParam() {

    $("form#createMalfunzionamento input[type=submit]#submitaddMalf").unbind("click").click(function (e) {
        var nome = $("form#createMalfunzionamento input[type=text]#nome_malfunzionamento").val();
        var descrizione = $("form#createMalfunzionamento textarea#descrizione_malfunzionamento").val();
        var data = new Array(nome, descrizione);
        action_ajax = baseUrl + "/malfunzionamento/createm";
        e.preventDefault();
        ajaxinsertmalf(action_ajax, data);
    });

    $("form#createSoluzione input[type=submit]#submitaddSol").unbind("click").click(function (e) {
        var nome = $("form#createSoluzione input[type=text]#nome_soluzione").val();
        var descrizione = $("form#createSoluzione textarea#descrizione_soluzione").val();
        var data = new Array(nome, descrizione);
        action_ajax = baseUrl + "/malfunzionamento/creates";
        e.preventDefault();
        ajaxinsertsol(action_ajax, data);
    });

    $("form#editMalfunzionamento input[type=submit]").click(function(e){
        var nome = $("form#editMalfunzionamento input[type=text]#nome").val();
        var desc = $("form#editMalfunzionamento textarea#descrizione").val();
        if(nome=="" || desc==""){
            $("#modal-alert h3.msg").html("I campi non possono essere vuoti");
            e.preventDefault();
        }else if(nome=="" && desc==""){
            $("#modal-alert h3.msg").html("I campi non possono essere vuoti");
            e.preventDefault();
        }else{
            e.submit();
        }
    });

    $("form#editSoluzione input[type=submit]").click(function(e){
        var nome = $("form#editSoluzione input[type=text]#nome").val();
        var desc = $("form#editSoluzione textarea#descrizione").val();
        if(nome=="" || desc==""){
            $("#modal-alert h3.msg").html("I campi non possono essere vuoti");
            e.preventDefault();
        }else if(nome=="" && desc==""){
            $("#modal-alert h3.msg").html("I campi non possono essere vuoti");
            e.preventDefault();
        }else{
            e.submit();
        }
    });
}

function loginForm() {

    $("form#login input[type=text]").val("");
    $("form#login input[type=password]").val("");

    $("form#login input[type=text]").focusout(function () {
        if ($(this).val() == '') {
            $(this).addClass("emptyField").attr("placeholder", "Immettere " + $(this).attr("name"));
            $("form#formContatti input[type=submit]").attr('disabled', 'disabled');
        }
    });

    $("form#login input[type=password]").focusout(function () {
        if ($(this).val() == '') {
            $(this).addClass("emptyField").attr("placeholder", "Immettere " + $(this).attr("name"));
            $("form#formContatti input[type=submit]").attr('disabled', 'disabled');
        }
    });
}

/**
 * LIVELLO 1-2-3
 */

/**
 * Preleva l'id del malfunzionamento contenuto nell'attributo value all'interno del href.
 * L'id viene passato alla funzione ajaxmalfdetails() che renderizza il risultato nel div#modal-box
 */
function getValueMalf() {
    $("#modal-change-box i.fa-times").click(function(){
        $("#modal-change-box").fadeOut("fast");
    });

    $("a.ajaxmalf").unbind("click").click(function (e) {
        var name_malf = $(this).find(".tab-element:nth-child(2)").html();
        var id_malf=$(this).attr("value");

        switch (role) {
            case roleType[0]:
                $("#modal-change-box").fadeIn("slow", function () {
                    $("#modal-change-box-content").fadeIn("slow");
                });
                $("#modal-change-box-content span").html(name_malf);
                var url=baseUrl+"/catalogo/descrizionemalf";
                ajaxgetdescrizionemalf(id_malf,url);

                id_ajax = $(this).attr("value");
                action_ajax = baseUrl + "/catalogo/findsolution";
                ajaxmalfdetails(id_ajax, action_ajax);

                e.preventDefault();

                break;

            case roleType[1]:
                e.preventDefault();
                if($(this).hasClass("prodotto") || $(this).hasClass("componente")){

                    $("#modal-change-box").fadeIn("slow", function () {
                        $("#modal-change-box-content").fadeIn("slow");
                    });
                    $("#modal-change-box-content span").html(name_malf);

                    var url=baseUrl+"/catalogo/descrizionemalf";
                    ajaxgetdescrizionemalf(id_malf,url);

                    id_ajax = $(this).attr("value");
                    action_ajax = baseUrl + "/catalogo/findsolution";
                    e.preventDefault();
                    ajaxmalfdetails(id_ajax, action_ajax);
                }else{

                    var i;
                    var idSelected = $(this).attr("value");

                    $(".bottom-bar").fadeIn("slow");
                    $(".bottom-bar .btn:nth-child(2)").fadeIn("slow");
                    $(".bottom-bar .btn:nth-child(3)").fadeIn("slow");
                    $(".bottom-bar .btn:nth-child(4)").fadeIn("slow");
                    $(".bottom-bar .btn:nth-child(5)").fadeIn("slow");


                    for (i = 0; i < $("a.ajaxmalf").length; i++) {
                        $("a.ajaxmalf").removeClass("active");
                    }
                    $(this).addClass("active");

                    $(".bottom-bar .btn:nth-child(3)").attr("name", name_malf);
                    $(".bottom-bar .btn:nth-child(4)").attr("name", name_malf);


                    idPass(idSelected);
                }

                break;

            case roleType[2]:
                e.preventDefault();

                if($(this).hasClass("prodotto") || $(this).hasClass("componente")){
                    $("#modal-change-box").fadeIn("slow", function () {
                        $("#modal-change-box-content").fadeIn("slow");
                    });

                    var url=baseUrl+"/catalogo/descrizionemalf";
                    ajaxgetdescrizionemalf(id_malf,url);

                    $("#modal-change-box-content span").html(name_malf);
                    id_ajax = $(this).attr("value");
                    action_ajax = baseUrl + "/catalogo/findsolution";
                    e.preventDefault();
                    ajaxmalfdetails(id_ajax, action_ajax);
                }else{
                    var i;
                    var idSelected = $(this).attr("value");

                    $(".bottom-bar").fadeIn("slow");
                    $(".bottom-bar .btn:nth-child(2)").fadeIn("slow");
                    $(".bottom-bar .btn:nth-child(3)").fadeIn("slow");
                    $(".bottom-bar .btn:nth-child(4)").fadeIn("slow");
                    $(".bottom-bar .btn:nth-child(5)").fadeIn("slow");


                    for (i = 0; i < $("a.ajaxmalf").length; i++) {
                        $("a.ajaxmalf").removeClass("active");
                    }
                    $(this).addClass("active");

                    $(".bottom-bar .btn:nth-child(3)").attr("name", name_malf);
                    $(".bottom-bar .btn:nth-child(4)").attr("name", name_malf);
                    idPass(idSelected);
                }

                break;
        }
    });


    $("a.associazione").unbind("click").click(function(e){
        $("#modal-change-box").fadeIn("slow", function () {
            $("#modal-change-box-content").fadeIn("slow");
        });
        var nome=$(this).find(".nome").html();
        id_ajax=$(this).attr("value");
        $("#modal-change-box-content span").html(nome);
        $("#modal-change-box-content span").attr("value",id_ajax);
        if($(this).hasClass("prodotto")){
            action_ajax=baseUrl+"/malfunzionamento/assprodmalf";
            ajaxassprodmalf(id_ajax, action_ajax);
            e.preventDefault();
        }else if($(this).hasClass("componente")){
            action_ajax=baseUrl+"/malfunzionamento/asscompmalf";
            ajaxasscompmalf(id_ajax, action_ajax);
            e.preventDefault();
        }
    });


}
function ajaxgetdescrizionemalf(id,url){
        $.ajax({
            type: "POST",
            url: url,
            data: {"id": id},
            dataType: "JSON",
            success: function (data) {
                console.log(data);
                $("#modal-change-box-content span.desc-malf").html(data);
            },
            error: function () {
                alert("Inserire un pop up di errore");
            }
        });
}



function ajaxassprodmalf(id, url){
    $.ajax({
        type: "POST",
        url: url,
        data: {"id": id},
        dataType: "JSON",
        success: function (data) {
            $(".solutions-list").html("");
            var dataParse= $.parseJSON(data);
            console.log(dataParse);
            var i;
            var selector = $(".solutions-list");
            for (i = 0; i < dataParse.length; i++) {
                if (dataParse[i]['status'] == true) {
                    selector.append("<div class='item active malfunzionamento' value=" + dataParse[i]['malfunzionamento']['id_malfunzionamento'] + ">" + dataParse[i]['malfunzionamento']['nome'] + "</div>");
                } else {
                    selector.append("<div class='item malfunzionamento' value=" + dataParse[i]['malfunzionamento']['id_malfunzionamento'] + ">" + dataParse[i]['malfunzionamento']['nome'] + "</div>");
                }
            }
            initMalf();
        },
        error: function () {
            alert("Inserire un pop up di errore");
        }
    });
}

function ajaxasscompmalf(id, url){
    $.ajax({
        type: "POST",
        url: url,
        data: {"id": id},
        dataType: "JSON",
        success: function (data) {
            $(".solutions-list").html("");
            var dataParse= $.parseJSON(data);
            console.log(dataParse);
            var i;
            var selector = $(".solutions-list");
            for (i = 0; i < dataParse.length; i++) {
                if (dataParse[i]['status'] == true) {
                    selector.append("<div class='item active componente' value=" + dataParse[i]['malfunzionamento']['id_malfunzionamento'] + ">" + dataParse[i]['malfunzionamento']['nome'] + "</div>");
                } else {
                    selector.append("<div class='item componente' value=" + dataParse[i]['malfunzionamento']['id_malfunzionamento'] + ">" + dataParse[i]['malfunzionamento']['nome'] + "</div>");
                }
            }
            initMalf();
        },
        error: function () {
            alert("Inserire un pop up di errore");
        }
    });
}


function initBottomBar() {
    $(".btn.add-malf").click(function () {
        $("#modal-box").fadeIn("fast", function () {
            $("#modal-alert.crud").fadeIn("fast");
        });
    });
}
function idPass(id) {

    id_ajax=id;

    $(".btn").unbind("click").click(function (e) {
        if ($(this).hasClass("remove-malf")) {
            $("#modal-box").fadeIn("slow", function () {
                $("#modal-alert.delete").fadeIn("slow");
            });
            const name = $(this).attr("name");
            $("#modal-alert.delete").html("" +
                "<p>Si desidera eliminare il malfunzionamento: <br />" +
                "<span class='delete-item'>" + name + "</span><br/><br/>" +
                "<span class='yes' value=" + id_ajax + ">Si</span><span class='no'>no</span>" +
                "</p>");
            initYesNoButtonMalf();
        }

        if ($(this).hasClass("change-ass")) {
            const name = $(this).attr("name");
            $("#modal-change-box").fadeIn("slow", function () {
                $("#modal-change-box-content").fadeIn("slow");
            });

            var url=baseUrl+"/catalogo/descrizionemalf";
            ajaxgetdescrizionemalf(id_ajax,url);

            $("#modal-change-box-content span").attr("value",id_ajax);
            action_ajax = baseUrl + "/malfunzionamento/associazione";
            $("#modal-change-box-content span").html(name);
            initMalf();
            ajaxFindSolutinosFromMalf(id_ajax, action_ajax);
        }

        if($(this).hasClass("remove-sol")){
            $("#modal-box").fadeIn("slow", function () {
                $("#modal-alert.delete").fadeIn("slow");
            });
            const name = $(this).attr("name");
            $("#modal-alert.delete").html("" +
                "<p>Si desidera eliminare la soluzione: <br />" +
                "<span class='delete-item'>" + name + "</span><br/><br/>" +
                "<span class='yes' value=" + id_ajax + ">Si</span><span class='no'>no</span>" +
                "</p>");
            initYesNoButtonSol();
        }

        if($(this).hasClass("edit-sol")){
            var path_sol=$(this).attr("href");
            $(this).attr("href",path_sol+"/id/"+id_ajax);
        }

        if($(this).hasClass("edit-malf")){
            var path_malf=$(this).attr("href");
            $(this).attr("href",path_malf+"/id/"+id_ajax);
        }
    });
}

function initYesNoButtonMalf() {
    $("#modal-alert span").click(function () {
        if ($(this).hasClass("yes")) {
            id_ajax = $(this).attr("value");
            action_ajax = baseUrl + "/malfunzionamento/deletemalfunzionamento";
            ajaxdeletemalfunzionamento(id_ajax, action_ajax);
        } else if ($(this).hasClass("no")) {
            $("#modal-alert").html("<p>Non è stato eliminato nessun malfunzionamento</p>");
            setTimeout(function () {
                $("#modal-box").fadeOut("fast", function () {
                    $("#modal-alert").html("");
                });
            }, 2000);
        }
    });
}

function initYesNoButtonSol() {
    $("#modal-alert span").click(function () {
        if ($(this).hasClass("yes")) {
            id_ajax = $(this).attr("value");
            action_ajax = baseUrl + "/malfunzionamento/deletesoluzione";
            ajaxdeletesoluzione(id_ajax, action_ajax);
        } else if ($(this).hasClass("no")) {
            $("#modal-alert").html("<p>Non è stato eliminata nessuna soluzione</p>");
            setTimeout(function () {
                $("#modal-box").fadeOut("fast", function () {
                    $("#modal-alert").html("");
                });
            }, 2000);
        }
    });
}



/*DELETE SOLUZIONE*/
function ajaxdeletesoluzione(id, url) {
    $.ajax({
        type: "POST",
        url: url,
        data: {"id": id},
        dataType: "JSON",
        success: function (data) {
            if (data == "1") {

                $("#modal-alert").html("<p>Eliminazione avvenuta con successo</p>");
                setTimeout(function () {
                    $("#modal-box").fadeOut("fast");
                }, 2000);

                setTimeout(function () {
                    window.location.reload();
                }, 2500);

            } else if (data == "0") {

                $("#modal-alert").html("<p>Impossibile eliminare la soluzione selezionata perchè è associata " +
                    "ad un malfunzionamento</p>");
                setTimeout(function () {
                    $("#modal-box").fadeOut("fast");
                }, 2000);

                setTimeout(function () {
                    window.location.reload();
                }, 2500);
            }
        },
        error: function () {
            alert("Inserire un pop up di errore");
        }
    });
}

function ajaxmalfdetails(id, url) {
    $.ajax({
        type: "POST",
        url: url,
        data: {"id": id},
        dataType: "JSON",
        success: function (data) {
            $(".solutions-list").html("");
            var i;
            var selector = $("#modal-change-box-content .solutions-list");
            for (i = 0; i < data['soluzione'].length; i++) {
                selector.append("<div class='item' value=" + data['soluzione'][i]['id_soluzione'] + ">" + data['soluzione'][i]['nome'] + "</div>");
            }
            initMalf();
        },
        error: function () {
            alert("Inserire un pop up di errore");
        }
    });
}

function ajaxdeletemalfunzionamento(id, url) {
    $.ajax({
        type: "POST",
        url: url,
        data: {"id": id},
        dataType: "JSON",
        success: function (data) {
            if (data == "1") {
                $("#modal-alert").html("<p>Eliminazione avvenuta con successo</p>");
                setTimeout(function () {
                    $("#modal-box").fadeOut("fast");
                }, 3500);

                setTimeout(function () {
                    window.location.reload();
                }, 5000);

            } else if (data == "0") {

                $("#modal-alert").html("<p>Impossibile eliminare il malfunzionamento selezionato perchè è associato " +
                    "ad un prodotto o ad una componente</p>");
                setTimeout(function () {
                    $("#modal-box").fadeOut("fast");
                }, 3500);

                setTimeout(function () {
                    window.location.reload();
                }, 5000);
            }
        },
        error: function () {
            alert("Inserire un pop up di errore");
        }
    });
}


function ajaxinsertmalf(url, data) {
    $.ajax({
        type: "POST",
        url: url,
        data: {"data": data},
        dataType: "JSON",
        success: function (data){
        if(data=="error"){
            $("#modal-alert.crud h3.msg").html("I campi non possono essere vuoti");
        }else
            if (data == 0 || data == null) {
                $("#modal-alert.crud").html("<p>Inserimento non riuscito</p>");
                setTimeout(function () {
                    $("#modal-box").fadeOut("fast", function () {
                        window.location.reload();
                    });
                }, 3000);
            } else if(data=="duplicate"){
                $("#modal-alert.crud h3.msg").html("Attenzione!<br />Nome già presente nel database");
            }else {
                $("#modal-alert.crud").html("<p>Inserimento effettuato correttamente<br />Reindirizzamento in corso...</p>");
                setTimeout(function () {
                    $("#modal-box").fadeOut("fast");
                    window.location = (baseUrl + "/catalogo/malfunzionamentilist");
                }, 3000);
            }
        },
        error: function () {
            alert("Inserire un pop up di errore");
        }
    });
}


function ajaxinsertsol(url, data) {
    $.ajax({
        type: "POST",
        url: url,
        data: {"data": data},
        dataType: "JSON",
        success: function (data) {
            if(data=="error"){
                $("#modal-alert.crud h3.msg").html("I campi non possono essere vuoti");
            }else if (data == 0 || data == null) {
                $("#modal-alert.crud").html("<p>Inserimento non riuscito</p>");
                setTimeout(function () {
                    $("#modal-box").fadeOut("fast", function () {
                        window.location.reload();
                    });
                }, 3000);
            }else if(data=="duplicate"){
                $("#modal-alert.crud h3.msg").html("Attenzione!<br />Nome già presente nel database");
            } else {
                $("#modal-alert.crud").html("<p>Inserimento effettuato correttamente<br />Reindirizzamento in corso...</p>");
                setTimeout(function () {
                    $("#modal-box").fadeOut("fast");
                    window.location = (baseUrl + "/malfunzionamento/solutionlist");
                }, 3000);
            }
        },
        error: function () {
            alert("Inserire un pop up di errore");
        }
    });
}


function ajaxsolutionlist(id, url) {
    $.ajax({
        type: "POST",
        url: url,
        data: {"id": id},
        dataType: "JSON",
        success: function (data) {
            var test = $.parseJSON(data);
            console.log(test);
        },
        error: function () {
            alert("Inserire un pop up di errore");
        }
    });
}


/*LIVELLO 0 -- INIT PARAMETRI RICERCA*/
function initSearchFilter() {
    $(".searchSide span.reset-filter").click(function () {
        window.location.reload();
    });

    $(".element input[type=radio]").click(function () {
        id_ajax = $(this).attr("value");
        action_ajax = baseUrl + "/public/trovasottocategorie";
        $(".element-subcategory").fadeOut("fast");
        ajaxProdotti(id_ajax, action_ajax);
    });

    $("#ricerca input[type=submit]").click(function (e) {
        e.preventDefault();
        txt_word_search_ajax = $("form#ricerca input[type=text]").val();
        if (txt_word_search_ajax == "") {
            $("form#ricerca input[type=submit]").attr('disabled', 'disabled');
        } else {
            action_ajax = baseUrl + "/public/ricercaprodottobydesc";
            ajaxSearchProdotti(txt_word_search_ajax, action_ajax);
        }
    });

    $("#ricerca input[type=text]").focusin(function () {
        $("form#ricerca input[type=submit]").removeAttr('disabled');
    });
}

function initSearchSubFilter() {
    $(".element-subcategory input[type=radio]").click(function () {
        id_ajax = $(this).attr("value");
        action_ajax = baseUrl + "/public/filtraprodottibysottocategoria";
        ajaxFiltroProdotti(id_ajax, action_ajax);
    });
}


/*LIVELLO 0 -- AJAX PRODOTTI*/
/**
 *
 * ajaxProdotti è una funzione che permette di popolare il filtro della barra di ricerca
 *
 * @param id ID della categoria selezionata dalla barra di ricerca
 * @param url URL associato all'azione da richiamare nel controller
 */
function ajaxProdotti(id, url) {
    $.ajax({
        type: "POST",
        url: url,
        data: {"id_categoria": id},
        dataType: "JSON",
        success: function (data) {
            var i;
            if (data.length == 0) {
                $(".element-subcategory").html("<h3>" + noElements + "</h3>");
            } else if (data.length > 0) {
                $(".searchSide span.reset-filter").fadeIn("fast");
                $(".element-subcategory").html("<h3>" + filtraCategoria + "</h3>");
                setTimeout(function () {
                    for (i = 0; i < data.length; i++) {
                        $(".element-subcategory").append(
                            '<div class="element"><input type="radio" value="' + data[i]['id_sottocategoria'] + '" name="sottoCategoria">' + data[i]['nome'] + '</div>');
                    }
                    initSearchSubFilter();

                }, 50);
            }
            $(".element-subcategory").fadeIn("fast");

        },
        error: function () {
            alert("Inserire un pop up di errore");
        }
    });
}


function ajaxFiltroProdotti(id, url) {
    $.ajax({
        type: "POST",
        url: url,
        data: {"id_sottocategoria": id},
        dataType: "JSON",
        success: function (data) {
            console.log(data);
            if (data.length == 0) {
                //Se non ci sono prodotto nella sottocategoria
                activeModalAlert("non ci sono prodotti con questa sottocategoria");
                $(".product-item-row").html("").css("border","none");

            } else if (data.length > 0) {

                $("#main-content-products").fadeOut("fast");
                $("#main-content-products").html("");

                setTimeout(function () {
                    productListResult(data);
                    initProductList();
                }, 20);
            }
            $("#main-content-products").fadeIn("fast");
        },
        error: function () {
            alert("Inserire un pop up di errore");
        }
    });
}


//Inizializzazione della finestra modal per la visualizzazione dei prodotti e di altri scenari presenti nei diversi livelli
function initModal() {
    $("#modal-box i.fa-times").click(function () {
        $("#modal-box").fadeOut("fast");
        $("html").removeAttr("style");
    });

    //$("#modal-box").click(function(){
    //    $(this).fadeOut("fast");
    //});
}

function initProductList() {
    $(".product-item-row").click(function () {
        id_ajax = $(this).attr("value");
        action_ajax = baseUrl + "/public/getprodottobyid";
        ajaxGetProdotto(id_ajax, action_ajax);
    });
}

//AJAX per la ricerca dello specifico prodotto. Il risultato viene visualizzato nel #modal-box
function ajaxGetProdotto(id, url) {
    $.ajax({
        type: "POST",
        url: url,
        data: {"id_prodotto": id},
        dataType: "JSON",
        success: function (data) {
            var path = baseUrlImg + data['img_path'];
            console.log(data);
            $("#modal-box").fadeIn("fast");
            $("#modal-content").fadeIn("fast");
            $(".modal-img").attr("style", "background-image:url(" + path + ")");
            $("#modal-box p.modello").html(data['nome']);
            $("#modal-box p.descrizione").html(data['desc_prod']);
            $("#modal-box p.istruzioni-full").html(data['istruzioni']);
            $("#modal-box p.note-full").html(data['note']);
            $("html").css("overflow","hidden");
        },
        error: function () {
            alert("Inserire un pop up di errore");
        }
    });
}

//AJAX per la ricerca dello specifico prodotto tramite una parola immessa nella barra di ricerca.
// Il risultato viene visualizzato nel #modal-box

function ajaxSearchProdotti(word, url) {
    $.ajax({
        type: "POST",
        url: url,
        data: {"search": word},
        dataType: "JSON",
        success: function (data) {
            //console.log(data);
            if(data == 3) {
                modalAlert(data);
            }

            if (data == 0) {
                modalAlert(data);
            } else if (data == 1) {
                modalAlert(data);
            } else if (data == 2) {
                modalAlert(data);
            } else if (data.length > 0) {
                $("#main-content-products").fadeOut("fast");
                $("#main-content-products").html("");
                setTimeout(function () {
                    productListResult(data);
                    initProductList();
                }, 20);
            }
            $("#main-content-products").fadeIn("fast");
        },
        error: function () {
            alert("Inserire un pop up di errore");
        }
    });
}


function productListResult(data) {
    var i;
    $("#main-content-products").html("<h2>Prodotti</h2>");
    for (i = 0; i < data.length; i++) {
        var path = "'" + baseUrlImg + data[i]["img_path"] + "'";
        $("#main-content-products").append('<div class="product-item-row" value="' + data[i]['id_prodotto'] + '">' +
            '<div class="product-image bg" style="background-image: url(' + path + ');"></div><div class="product-details-box"><p>Modello:</p><p class="modello">' + data[i]['nome'] + '</p><p>Descrizione:</p><p class="descrizione">' + data[i]['desc_prod'] + '</p></div></div>');
    }
}

function modalAlert(value) {
    switch (value) {
        case 0:
            activeModalAlert(errorResearch[0]);
            break;
        case 1:
            activeModalAlert(errorResearch[1]);
            break;
        case 2:
            activeModalAlert(errorResearch[2]);
            break;
        case 3:
            activeModalAlert(errorResearch[3]);
            break;
        default:
            break
    }
}

function activeModalAlert(stringMsg) {
    $("#modal-box").fadeIn("fast");
    $("#modal-box").html(alert_ajax);
    $("#modal-alert").fadeIn("fast");
    setTimeout(function () {
        $("#modal-alert").html("<p>" + stringMsg + "</p>");
    }, 50);
    setTimeout(function () {
        $("#modal-box").fadeOut("slow");
        $("#modal-box").html(modal_ajax);
    }, 2500);
}


/*ALERT ON*/
function activeAlert() {
    $("#modal-box").fadeIn("fast");
    $("#modal-alert").fadeIn("fast");
}


function setModalAlert() {
    $("#modal-box").fadeIn("fast");
    $("#modal-box").html(alert_ajax);
    $("#modal-alert").fadeIn("fast");
}

//AJAX LIVELLO 2
/**
 *
 * @param id associato al malfunzionamento selezionato
 * @param url associata alla Action da richiamare nel MalfunzionamentoController
 */
function ajaxassociazione(id, url) {
    $.ajax({
        type: "POST",
        url: url,
        data: {"id": id},
        dataType: "JSON",
        success: function (data) {
            setTimeout(function () {
                $(".col.soluzioni").html("");
                $(".col.soluzioni").fadeIn("fast");
                var i;
                for (i = 0; i < data.length; i++) {
                    if (data[i]['status'] == true) {
                        $(".col.soluzioni").append("<div class='item active' value=" + data[i]['soluzione']['id_soluzione'] + ">" + data[i]['soluzione']['nome'] + "</div>");
                    } else {
                        $(".col.soluzioni").append("<div class='item' value=" + data[i]['soluzione']['id_soluzione'] + ">" + data[i]['soluzione']['nome'] + "</div>");
                    }
                }
                initMalf();
            }, 100);

        },
        error: function () {
            alert("Inserire un pop up di errore");
        }
    });
}

/**
 *
 * @param id del malunzionamento selezionato
 * @param url action da richiamare dal MalfunzionamentiController
 */

function ajaxFindSolutinosFromMalf(id, url) {
    $.ajax({
        type: "POST",
        url: url,
        data: {"id": id},
        dataType: "JSON",
        success: function (data) {
            console.log(data);
            setTimeout(function () {
                $(".solutions-list").html("");

                var i;
                var selector = $(".solutions-list");
                if(data.length>0){
                    for (i = 0; i < data.length; i++) {
                        if (data[i]['status'] == true) {
                            selector.append("<div class='item active' value=" + data[i]['soluzione']['id_soluzione'] + ">" + data[i]['soluzione']['nome'] + "</div>");
                        } else {
                            selector.append("<div class='item' value=" + data[i]['soluzione']['id_soluzione'] + ">" + data[i]['soluzione']['nome'] + "</div>");
                        }
                    }
                    initMalf();
                }else{
                    $("#modal-change-box-content p.wrong-insert").html("Non sono presenti soluzioni nel database");
                }

            }, 100);

        },
        error: function () {
            alert("Inserire un pop up di errore");
        }
    });
}


function ajaxFindSolutionDescription(id, url) {
    $.ajax({
        type: "POST",
        url: url,
        data: {"idSoluzione": id},
        dataType: "JSON",
        success: function (data) {
            //console.log(data);
            var selector = $("#modal-change-box-description p");
            selector.fadeOut("fast", function () {
                setTimeout(function () {
                    selector.html(data[0]['descrizione']);
                    selector.fadeIn("fast");
                }, 500);
            });



        },
        error: function () {
            alert("Inserire un pop up di errore");
        }
    });
}


function ajaxdescrizionecomp(id, url) {
    $.ajax({
        type: "POST",
        url: url,
        data: {"idComponente": id},
        dataType: "JSON",
        success: function (data) {
            var selector = $("#modal-change-box-description p");
            selector.fadeOut("fast", function () {
                setTimeout(function () {
                    selector.html(data['desc_comp']);
                    selector.fadeIn("fast");
                }, 500);
            });
        },
        error: function () {
            alert("Inserire un pop up di errore");
        }
    });
}

function initMalf() {

    /** LIVELLO 2 - GESTIONE ASSOCIAZIONE MAL-SOL */

    var timer;
    $("#modal-change-box .solutions-list .item").hover(function(){
        if(!$(this).hasClass("prod-comp")){
            id_ajax = $(this).attr("value");
            action_ajax = baseUrl + "/catalogo/descrizionesoluzione";
            timer=setTimeout(function(){
                ajaxFindSolutionDescription(id_ajax, action_ajax);
            },50);
        }else if($(this).hasClass("prod-comp")){
            id_ajax = $(this).attr("value");
            action_ajax = baseUrl + "/admin/descrizionecomponente";
            timer=setTimeout(function(){
                ajaxdescrizionecomp(id_ajax, action_ajax);
            },50);
        }

    },function(){
        if(!$(this).hasClass("prod-comp")) {
            clearTimeout(timer);
            $("#modal-change-box-description p").fadeOut("fast");
        }
    });


    $(".solutions-list .item").unbind("click").click(function () {

        if($(this).hasClass("componente")){
            var componente_selected = $("#modal-change-box-content span").attr("value");
            id_ajax = $(this).attr("value");
            if ($(this).hasClass("active")) {
                if(role=='staff' || role == 'admin'){
                    if (confirm('Sicuro di voler rimuovere il malfunzionamento selezionato?')) {
                        action_ajax = baseUrl + "/malfunzionamento/ajaxremovemalfunzionamentocomponente";
                        ajaxRemoveMalfToComp($(this),id_ajax, componente_selected, action_ajax);
                    }
                }
            }else{
                if(role=='staff' || role == 'admin'){
                    if (confirm('Sicuro di voler aggiungere il malfunzionamento selezionato?')) {
                        action_ajax = baseUrl + "/malfunzionamento/ajaxaddmalfunzionamentocomponente";
                        ajaxAddMalfToComp($(this),id_ajax, componente_selected, action_ajax);
                    }
                }
            }
        }else if($(this).hasClass("malfunzionamento")){
            var prodotto_selected = $("#modal-change-box-content span").attr("value");
            id_ajax = $(this).attr("value");
            if ($(this).hasClass("active")) {
                if(role=='staff' || role == 'admin'){
                    if (confirm('Sicuro di voler rimuovere il malfunzionamento selezionato?')) {
                        action_ajax = baseUrl + "/malfunzionamento/ajaxremovemalfunzionamentoprodotto";
                        ajaxRemoveMalfToProd($(this),id_ajax, prodotto_selected, action_ajax);
                    }
                }
            }else{
                if(role=='staff' || role == 'admin'){
                    if (confirm('Sicuro di voler aggiungere il malfunzionamento selezionato?')) {
                        action_ajax = baseUrl + "/malfunzionamento/ajaxaddmalfunzionamentoprodotto";
                        ajaxAddMalfToProd($(this),id_ajax, prodotto_selected, action_ajax);
                    }
                }
            }
        }else if($(this).parent().hasClass("no-selection")){
            return;
        }else if($(this).hasClass("prod-comp")){
            id_ajax = $(this).attr("value");
            var prodotto_selected_to_ass = $("#modal-change-box-content span").attr("value");

            //Crea o distrugge l'associazione prodotto-componente
            if (!$(this).hasClass("active")) {
                if(role == 'admin'){
                    if (confirm('Sicuro di voler aggiungere la componente selezionata?')) {
                        action_ajax = baseUrl + "/admin/ajaxaddprodottocomp";
                        ajaxAddProdToComp($(this),id_ajax, prodotto_selected_to_ass, action_ajax);
                    }
                }
            } else {
                if(role == 'admin'){
                    if (confirm('Sicuro di voler eliminare la componente selezionata?')) {
                        action_ajax = baseUrl + "/admin/ajaxremoveprodottocomp";
                        ajaxRemoveProdToComp($(this),id_ajax, prodotto_selected_to_ass, action_ajax);
                    }
                }
            }


        }else {
            var malf_selected = $("#modal-change-box-content span").attr("value");
            id_ajax = $(this).attr("value");
            if (!$(this).hasClass("active")) {
                if (role == 'staff' || role == 'admin') {
                    if (confirm('Sicuro di voler aggiungere la soluzione selezionata?')) {
                        action_ajax = baseUrl + "/malfunzionamento/ajaxaddsoluzionetomalf";
                        ajaxAddSoluzioneToMalf($(this), id_ajax, malf_selected, action_ajax);
                    }
                }
            } else {
                if (role == 'staff' || role == 'admin') {
                    if (confirm('Sicuro di voler eliminare la soluzione selezionata?')) {
                        action_ajax = baseUrl + "/malfunzionamento/ajaxremovesoluzionetomalf";
                        ajaxRemoveSoluzioneToMalf($(this), id_ajax, malf_selected, action_ajax);
                    }
                }
            }
        }
    });
}


/** LIVELLO 2 -- ASSEGNAZIONE O RIMOZIONE DI UNA SOLUZIONE DA UN MALFUNZIONAMENTO */
function ajaxAddSoluzioneToMalf(itemSelected,idSoluzione, idMalfunzionamento, url) {
    $.ajax({
        type: "POST",
        url: url,
        data: {"idSoluzione": idSoluzione, "idMalfunzionamento": idMalfunzionamento},
        dataType: "JSON",
        success: function () {
            itemSelected.addClass("active");
            $("#modal-change-box p.correct-insert").fadeIn("slow");
            $("#modal-change-box p.correct-insert").html("Inserimento effettuato correttamente");
            setTimeout(function(){
                $("#modal-change-box p.correct-insert").fadeOut("slow");
            },2000);
        },
        error: function () {
            $("#modal-change-box p.wrong-insert").fadeIn("slow");
            $("#modal-change-box p.wrong-insert").html("Inserimento non effettuato correttamente");
            setTimeout(function(){
                $("#modal-change-box p.wrong-insert").fadeOut("slow");
            },2000);
        }
    });
}

function ajaxRemoveSoluzioneToMalf(itemSelected, idSoluzione, idMalfunzionamento, url) {
    $.ajax({
        type: "POST",
        url: url,
        data: {"idSoluzione": idSoluzione, "idMalfunzionamento": idMalfunzionamento},
        dataType: "JSON",
        success: function () {
            itemSelected.removeClass("active");
            $("#modal-change-box p.correct-insert").fadeIn("slow");
            $("#modal-change-box p.correct-insert").html("Rimozione effettuata correttamente");
            setTimeout(function(){
                $("#modal-change-box p.correct-insert").fadeOut("slow");
            },2000);
        },
        error: function () {
            $("#modal-change-box p.wrong-insert").fadeIn("slow");
            $("#modal-change-box p.wrong-insert").html("Rimozione non effettuata correttamente");
            setTimeout(function(){
                $("#modal-change-box p.wrong-insert").fadeOut("slow");
            },2000);
        }
    });
}


function ajaxAddMalfToProd(itemSelected,idMalfunzionamento, idProdotto, url) {
    $.ajax({
        type: "POST",
        url: url,
        data: {"idMalfunzionamento": idMalfunzionamento, "idProdotto": idProdotto},
        dataType: "JSON",
        success: function () {
            itemSelected.addClass("active");
            $("#modal-change-box p.correct-insert").fadeIn("slow");
            $("#modal-change-box p.correct-insert").html("Inserimento effettuato correttamente");
            setTimeout(function(){
                $("#modal-change-box p.correct-insert").fadeOut("slow");
            },2000);
        },
        error: function () {
            $("#modal-change-box p.wrong-insert").fadeIn("slow");
            $("#modal-change-box p.wrong-insert").html("Inserimento non effettuato correttamente");
            setTimeout(function(){
                $("#modal-change-box p.wrong-insert").fadeOut("slow");
            },2000);
        }
    });
}

function ajaxRemoveMalfToProd(itemSelected,idMalfunzionamento, idProdotto, url) {
    $.ajax({
        type: "POST",
        url: url,
        data: {"idMalfunzionamento": idMalfunzionamento, "idProdotto": idProdotto},
        dataType: "JSON",
        success: function () {
            itemSelected.removeClass("active");
            $("#modal-change-box p.correct-insert").fadeIn("slow");
            $("#modal-change-box p.correct-insert").html("Rimozione effettuata correttamente");
            setTimeout(function(){
                $("#modal-change-box p.correct-insert").fadeOut("slow");
            },2000);
        },
        error: function () {
            $("#modal-change-box p.wrong-insert").fadeIn("slow");
            $("#modal-change-box p.wrong-insert").html("Rimozione non effettuata correttamente");
            setTimeout(function(){
                $("#modal-change-box p.wrong-insert").fadeOut("slow");
            },2000);
        }
    });
}

function ajaxAddMalfToComp(itemSelected,idMalfunzionamento, idComponente, url) {
    $.ajax({
        type: "POST",
        url: url,
        data: {"idMalfunzionamento": idMalfunzionamento, "idComponente": idComponente},
        dataType: "JSON",
        success: function () {
            itemSelected.addClass("active");
            $("#modal-change-box p.correct-insert").fadeIn("slow");
            $("#modal-change-box p.correct-insert").html("Inserimento effettuato correttamente");
            setTimeout(function(){
                $("#modal-change-box p.correct-insert").fadeOut("slow");
            },2000);
        },
        error: function () {
            $("#modal-change-box p.wrong-insert").fadeIn("slow");
            $("#modal-change-box p.wrong-insert").html("Inserimento non effettuato correttamente");
            setTimeout(function(){
                $("#modal-change-box p.wrong-insert").fadeOut("slow");
            },2000);
        }
    });
}

function ajaxRemoveMalfToComp(itemSelected,idComponente, idMalfunzionamento, url) {
    $.ajax({
        type: "POST",
        url: url,
        data: {"idMalfunzionamento": idMalfunzionamento, "idComponente": idComponente},
        dataType: "JSON",
        success: function () {
            itemSelected.removeClass("active");
            $("#modal-change-box p.correct-insert").fadeIn("slow");
            $("#modal-change-box p.correct-insert").html("Rimozione effettuata correttamente");
            setTimeout(function(){
                $("#modal-change-box p.correct-insert").fadeOut("slow");
            },2000);
        },
        error: function () {
            $("#modal-change-box p.wrong-insert").fadeIn("slow");
            $("#modal-change-box p.wrong-insert").html("Rimozione non effettuata correttamente");
            setTimeout(function(){
                $("#modal-change-box p.wrong-insert").fadeOut("slow");
            },2000);
        }
    });
}



function ajaxAddProdToComp(itemSelected,idComponente, idProdotto, url) {
    $.ajax({
        type: "POST",
        url: url,
        data: {"idComponente": idComponente, "idProdotto": idProdotto},
        dataType: "JSON",
        success: function () {
            itemSelected.addClass("active");
            $("#modal-change-box p.correct-insert").fadeIn("slow");
            $("#modal-change-box p.correct-insert").html("Inserimento effettuato correttamente");
            setTimeout(function(){
                $("#modal-change-box p.correct-insert").fadeOut("slow");
            },2000);
        },
        error: function () {
            $("#modal-change-box p.wrong-insert").fadeIn("slow");
            $("#modal-change-box p.wrong-insert").html("Inserimento non effettuato correttamente");
            setTimeout(function(){
                $("#modal-change-box p.wrong-insert").fadeOut("slow");
            },2000);
        }
    });
}



function ajaxRemoveProdToComp(itemSelected,idComponente, idProdotto, url) {
    $.ajax({
        type: "POST",
        url: url,
        data: {"idComponente": idComponente, "idProdotto": idProdotto},
        dataType: "JSON",
        success: function () {
            itemSelected.removeClass("active");
            $("#modal-change-box p.correct-insert").fadeIn("slow");
            $("#modal-change-box p.correct-insert").html("Rimozione effettuata correttamente");
            setTimeout(function(){
                $("#modal-change-box p.correct-insert").fadeOut("slow");
            },2000);
        },
        error: function () {
            $("#modal-change-box p.wrong-insert").fadeIn("slow");
            $("#modal-change-box p.wrong-insert").html("Rimozione non effettuata correttamente");
            setTimeout(function(){
                $("#modal-change-box p.wrong-insert").fadeOut("slow");
            },2000);
        }
    });
}

/**
 * AJAX PER LA RICERCA DELLE COMPONENTI DA ASSEGNARE AD UN PRODOTTO
 */

function ajaxassociazioneprodcomp(id,url){
    $.ajax({
        type: "POST",
        url: url,
        data: {"id": id},
        dataType: "JSON",
        success: function (data) {
            var i;
            var selector = $(".solutions-list");
            selector.html("");
            for (i = 0; i < data.length; i++) {
                if (data[i]['status'] == true) {
                    selector.append("<div class='item active prod-comp' value=" + data[i]['componente']['id_componente'] + ">" + data[i]['componente']['nome'] + "</div>");
                } else {
                    selector.append("<div class='item prod-comp' value=" + data[i]['componente']['id_componente'] + ">" + data[i]['componente']['nome'] + "</div>");
                }
            }
            initMalf();
        },
        error: function () {
            alert("Inserire un pop up di errore");
        }
    });
}


/**
 * Inizializzazione barra utente
 * */

function initBarUser() {
    $(".user").click(function () {
        if (flagUser) {
            $("#modal-change-box").fadeOut("fast");
            $(".user-sub").fadeIn("fast");
            $(this).css("background", "white");
            $(this).find("i.fa-user").css("color", "rgba(3,169,244,1)");
            $(this).find("p").css("color", "rgba(3,169,244,1)");
            flagUser = false;
        } else if (!flagUser) {
            //$("#modal-box").fadeIn("fast");
            userBtnIntit();
        }
    });

    $(".menu").click(function () {
        if (menuFlag) {
            $("html").css("overflow","hidden");

            //$("#modal-box").fadeOut("fast");
            $("#modal-change-box").fadeOut("fast");
            $(".popup-bg.menu-item").fadeIn("fast");
            $(this).css("background", "white");
            $(this).find("i.fa").css("color", "rgba(3,169,244,1)");
            $(".search i.fa").removeAttr("style");
            $(".search").removeAttr("style");
            $(".popup-bg.find").fadeOut("fast");
            userBtnIntit();
            setTimeout(function () {
                menuFlag = false;
            }, 200);
        } else {
            $("html").removeAttr("style");

            //$("#modal-box").fadeIn("fast");
            $(".popup-bg.menu-item").fadeOut("fast");
            $(this).removeAttr("style");
            $(this).find("i.fa").removeAttr("style");
            setTimeout(function () {
                menuFlag = true;
            }, 200);
        }
    });

    $(".popup-bg.menu-item").click(function () {
        $("html").removeAttr("style");
        $(this).fadeOut("fast");
        $(".menu").removeAttr("style");
        $(".fa.fa-bars").removeAttr("style");
    });
}

function userBtnIntit() {
    $(".user").removeAttr("style");
    $(".user i.fa-user").removeAttr("style");
    $(".user p").removeAttr("style");
    $(".user-sub").fadeOut("fast");
    setTimeout(function () {
        flagUser = true;
    }, 1000);
}

/*INPUT TEXT - FAQ*/
function faq(){

    var
        domanda="",
        risposta="",
        data;

    $("form#aggiungifaq textarea").focusout(function () {
        var id = $(this).attr("id");
        switch (id) {
            case 'domanda':
                domanda = $(this).val();
                checkField(domanda,$(this),"domanda");
                break;
            case 'risposta':
                risposta = $(this).val();
                checkField(risposta,$(this),"risposta");
                break;
        }

        $("form#aggiungifaq input[type=submit]").click(function (e) {
            data = [domanda, risposta];
            if (activeSubmit(data)) {
                e.submit
            } else {
                e.preventDefault();
            }
        });
    })
}


function editFaq() {

    var
        domanda = "",
        risposta = "",
        data;

    $("form#editfaq textarea").focusout(function () {
        var id = $(this).attr("id");
        switch (id) {
            case 'domanda':
                domanda = $(this).val();
                checkField(domanda,$(this),"domanda");
                break;
            case 'risposta':
                risposta = $(this).val();
                checkField(risposta,$(this),"risposta");
                break;
        }

        $("form#editfaq input[type=submit]").click(function (e) {
            data = [domanda, risposta];
            if (activeSubmit(data)) {
                e.submit;
            } else {
                e.preventDefault();
            }
        });
    });
}

function centro(){

    var
        nome="",
        indirizzo="",
        mail="",
        telefono="",
        descrizione="",
        data;

    $("form").mouseenter(function () {
        var id = $(this).attr("id");
        if (id == "createcentro" || id == "editcentro") {
            $("form#" + id + " input[type=text]").focusout(function () {
                var id = $(this).attr("id");
                switch (id) {
                    case 'nome':
                        nome = $(this).val();
                        checkField(nome, $(this), "nome");
                        break;
                    case 'indirizzo':
                        indirizzo = $(this).val();
                        checkField(indirizzo, $(this), "indirizzo");
                        break;
                    case 'mail':
                        mail = $(this).val();
                        validateMail(mail,$(this));
                        //checkField(mail, $(this), "mail");
                        break;
                    case 'telefono':
                        telefono = $(this).val();
                        validatePhone(telefono,$(this));
                        //checkField(telefono, $(this), "telefono");
                        break;
                }
            });

            $("form#" + id + " textarea").focusout(function () {
                var id = $(this).attr("id");
                switch (id) {
                    case 'descrizione':
                        descrizione = $(this).val();
                        checkField(descrizione, $(this), "descrizione");
                        break;
                }
            });

            $("form#" + id + " input[type=submit]").click(function (e) {
                if(id!='editcentro'){
                    data = [nome, indirizzo, mail, telefono, descrizione];
                    if (activeSubmit(data)) {
                        e.submit;
                    } else {
                        e.preventDefault();
                    }
                }

            });

        }
    });

}


function checkField(field,element,str){
    if(field==""){
        element.addClass("wrongField");
        $("#form-msg p.wrong-insert").html("Il campo "+str+" non può essere vuoto");

    }else{
        element.removeClass("wrongField").addClass("correctField");
    }
    if(element.hasClass("correctField")){
        $("#form-msg p.wrong-insert").html("");
    }
}

function validateMail(mail,element){
    var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
    if(!pattern.test(mail)){
        element.addClass("wrongField");
        $("#form-msg p.wrong-insert").html("La mail inserita:<br/>"+element.val()+"<br />non è valida.<br />Immettere una mail valida del tipo:<br />mail@dominio.(it,com,org...)");
        return false;
    }else{
        element.addClass("correctField").removeClass("wrongField");
        $("#form-msg p.wrong-insert").html("");
        return true;
    }
}

function validatePhone(phone,element){
    var pattern = new RegExp(/^[\+39]+[0-9]{6,11}$/i);
    if(!pattern.test(phone)){
        element.addClass("wrongField");
        $("#form-msg p.wrong-insert").html("Errore:<br/>" +
            " 1. Il campo può contenere solo caratteri numerici<br />" +
            "2. Il formato valido è: +39000000000 (min 6 - max 11)");
        return false;
    }else{
        element.addClass("correctField").removeClass("wrongField");
        $("#form-msg p.wrong-insert").html("");
        return true;
    }
}

function validateDate(data,element){
    var pattern = new RegExp(/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/);
    if(!pattern.test(data)){
        element.addClass("wrongField");
        $("#form-msg p.wrong-insert").html("Formato non valido<br />Immettere una data valida: YYYY-MM-DD");
        return false;
    }else{
        element.addClass("correctField").removeClass("wrongField");
        $("#form-msg p.wrong-insert").html("");
        return true;
    }
}

function activeSubmit(data){
    var i;
    var notNull=0;
        for(i=0; i<data.length; i++){
            if(data[i]!="") notNull++;
        }

        if(notNull==data.length){
            return true;
        }else{
            return false;
        }
}