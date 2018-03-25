<?php
    session_start();
    
    include("../views/classes/class_banco.php");
    include('../views/classes/class_pesquisar.php');
    
    $bd = new Banco();
    
    $id = $_GET['id'];
    
    $pesquisar_comentarios = new Pesquisar('tbl_comentarios','*','id_comentario = '.$id);
    $resultado_comentarios = $pesquisar_comentarios->pesquisar();
    
    while($comentarios = mysql_fetch_assoc($resultado_comentarios))
    {
        $retorno = '
            <section class="modal-dialog">
                <section class="modal-content">
                    <section class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                        <h4 class="modal-title">Editar Comentários</h4>
                    </section>
                    <form method = "post" action="" id="frmComentario" class="form-horizontal">
                        <section class="modal-body">
                                <section class="form-group">
                                    <section class="col-lg-14">
                                        <input type="text" name="id_coments" style="display:none" value="'.$comentarios['id_comentario'].'">
                                        <textarea id="comentario" rows="4" class="form-control" name="coment" placeholder="Digite aqui seu comentários!" required>'.utf8_encode($comentarios['comentario']).'</textarea>
                                    </section>
                                </section>        
                        </section>
                        <section class="modal-footer">
                            <button type="submit" id="editar" name="editar_coments" class="btn btn-default" >Editar!</button>
                            <button id = "cancelar" type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                        </section>
                    </form>
                </section>
            </section>
            
        ';
    }
    
    $caixa_dialogo = array('section' => $retorno);
    echo json_encode($caixa_dialogo);
    
?>