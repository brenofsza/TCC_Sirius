$(document).ready(function(){ 
 
    function verificarMaterialSalvo(){ 
 
        let idMaterial = $('#salvarMaterial').data('id'); 
 
        if(!idMaterial){ 
            return; 
        } 
 
        fetch("../php/verMatSalvo.php", { 
            method: "POST", 
            headers: { 
                "Content-Type": "application/x-www-form-urlencoded" 
            }, 
            body: "id_material=" + encodeURIComponent(idMaterial) 
        }) 
        .then(response => response.text()) 
        .then(retorno => { 
 
            if(retorno.trim() == "SALVO"){ 
                $('#salvarMaterial').html("Material salvo"); 
            } 
 
        }) 
        .catch(function(erro){ 
            console.log(erro); 
        }); 
 
    } 
 
 
    $('#salvarMaterial').click(function(){ 
 
        let idMaterial = $(this).data('id'); 
 
        $('#modalSalvarMaterial')[0].showModal(); 
 
        fetch("../php/buscarPastasModal.php", {
    method: "POST",
    headers: {
        "Content-Type": "application/x-www-form-urlencoded"
    },
    body: "id_material=" + encodeURIComponent(idMaterial)
})
.then(response => response.text())
.then(retorno => {

    console.log("RETORNO DAS PASTAS:", retorno);

    $('#pastasSalvar').html(retorno);

})
.catch(function(erro){

    console.log(erro);

    $('#pastasSalvar').html(
        "<p>Erro ao carregar as pastas.</p>"
    );

});
 
    }); 
 
 
    $('#fecharSalvarMaterial').click(function(){ 
        $('#modalSalvarMaterial')[0].close(); 
    }); 
 
 
    $(document).on('click', '.pastaSalvar', function(){ 
 
        let idPasta = $(this).data('id'); 
        let idMaterial = $('#salvarMaterial').data('id'); 
 
        fetch("../php/salvarMaterial.php", { 
            method: "POST", 
            headers: { 
                "Content-Type": "application/x-www-form-urlencoded" 
            }, 
            body: 
                "id_pasta=" + encodeURIComponent(idPasta) + 
                "&id_material=" + encodeURIComponent(idMaterial) 
        }) 
        .then(response => response.text()) 
        .then(retorno => { 
 
            if(retorno.trim() == "OK!"){ 
 
                $('#modalSalvarMaterial')[0].close(); 
 
                $('#salvarMaterial').html("Material salvo"); 
 
            } 
 
        }) 
        .catch(function(erro){ 
            console.log(erro); 
        }); 
 
    }); 
 
 
    if($('#modalAcessoNegado').length > 0){ 
 
        const modalAcesso = document.getElementById('modalAcessoNegado'); 
 
        modalAcesso.showModal(); 
 
 
        let idUsuario = $('#solicitarConexao').data('id'); 
 
        fetch("../php/buscarConexao.php", { 
            method: "POST", 
            headers: { 
                "Content-Type": "application/x-www-form-urlencoded" 
            }, 
            body: "id_usuario=" + encodeURIComponent(idUsuario) 
        }) 
        .then(response => response.text()) 
        .then(retorno => { 
 
            let resposta = retorno.trim(); 
 
            if(resposta == "PENDENTE"){ 
 
                $('#solicitarConexao').html("Conexão pendente"); 
 
            } else if(resposta == "ACEITA"){ 
 
                $('#solicitarConexao').html("Conectado"); 
 
            } 
 
        }) 
        .catch(function(erro){ 
            console.log(erro); 
        }); 
 
 
        $('#fecharAcessoNegado').click(function(){ 
 
            modalAcesso.close(); 
 
            history.back(); 
 
        }); 
 
 
        $('#solicitarConexao').click(function(){ 
 
            fetch("../php/conectarUsu.php", { 
                method: "POST", 
                headers: { 
                    "Content-Type": "application/x-www-form-urlencoded" 
                }, 
                body: "id_usuario=" + encodeURIComponent(idUsuario) 
            }) 
            .then(response => response.text()) 
            .then(retorno => { 
 
                let resposta = retorno.trim(); 
 
                if(resposta == "OK!"){ 
 
                    $('#solicitarConexao').html("Conexão pendente"); 
 
                } else if(resposta == "ACEITA"){ 
 
                    $('#solicitarConexao').html("Conectado"); 
 
                } else if(resposta == "CANCELADO"){ 
 
                    $('#solicitarConexao').html("Conectar"); 
 
                } 
 
            }) 
            .catch(function(erro){ 
                console.log(erro); 
            }); 
 
        }); 
 
    } 
 
 
    if($('#editarMaterial').length > 0){ 
 
        $('#editarMaterial').click(function(){ 
 
            let idMaterial = $(this).data('id'); 
 
            $('#editarIdMaterial').val(idMaterial); 
 
            $('#mensagemEditarMaterial').html( 
                "<p>Carregando...</p>" 
            ); 
 
            $('#modalEditarMaterial')[0].showModal(); 
 
            fetch("../php/buscarMaterialEdicao.php", { 
                method: "POST", 
                headers: { 
                    "Content-Type": "application/x-www-form-urlencoded" 
                }, 
                body: "id_material=" + encodeURIComponent(idMaterial) 
            }) 
            .then(response => response.json()) 
            .then(material => { 
 
                if(material.erro){ 
                    $('#mensagemEditarMaterial').html( 
                        "<p>Não foi possível carregar o material.</p>" 
                    ); 
                    return; 
                } 
 
                $('#editarTitulo').val(material.titulo); 
 
                $('#editarDisci').val(material.disci); 
                $('#editarIdDisci').val(material.id_disci); 
 
                $('#editarCont').val(material.cont); 
                $('#editarIdCont').val(material.id_cont); 
 
                $('#editarNivel').val(material.nivel); 
 
                $('input[name="editarStatus"][value="' + material.status + '"]').prop( 
                    "checked", 
                    true 
                ); 
 
                $('#editarDescricao').val(material.descricao); 
 
                $('#mensagemEditarMaterial').html(""); 
 
            }) 
            .catch(function(erro){ 
 
                console.log(erro); 
 
                $('#mensagemEditarMaterial').html( 
                    "<p>Erro ao carregar o material.</p>" 
                ); 
 
            }); 
 
        }); 
 
 
        $('#fecharEditarMaterial').click(function(){ 
            $('#modalEditarMaterial')[0].close(); 
        }); 
 
 
        $('#cancelarEditarMaterial').click(function(){ 
            $('#modalEditarMaterial')[0].close(); 
        }); 
 
 
        $('#editarDisci').typeahead({ 
 
            source: function(query, process){ 
 
                fetch("../php/buscarDisci.php", { 
                    method: "POST", 
                    headers: { 
                        "Content-Type": "application/x-www-form-urlencoded" 
                    }, 
                    body: "nome=" + encodeURIComponent(query) 
                }) 
                .then(response => response.json()) 
                .then(dados => { 
 
                    process(dados.map(function(disci){ 
                        return disci.nome; 
                    })); 
 
                    $('#editarDisci').data( 
                        'disciplinas', 
                        dados 
                    ); 
 
                }) 
                .catch(function(erro){ 
                    console.log(erro); 
                }); 
 
            }, 
 
            minLength: 1, 
            items: 8, 
 
            updater: function(nome){ 
 
                let disciplinas = 
                    $('#editarDisci').data('disciplinas') || []; 
 
                let disciplina = disciplinas.find(function(disci){ 
                    return disci.nome == nome; 
                }); 
 
                if(disciplina){ 
 
                    $('#editarIdDisci').val(disciplina.id); 
 
                    $('#editarCont').val(''); 
                    $('#editarIdCont').val(''); 
 
                } 
 
                return nome; 
 
            } 
 
        }); 
 
 
        $('#editarDisci').on('input', function(){ 
 
            $('#editarIdDisci').val(''); 
 
            $('#editarCont').val(''); 
            $('#editarIdCont').val(''); 
 
        }); 
 
 
        $('#editarCont').typeahead({ 
 
            source: function(query, process){ 
 
                let disci = $('#editarIdDisci').val(); 
 
                if(disci == ''){ 
                    return; 
                } 
 
                fetch("../php/buscarCont.php", { 
                    method: "POST", 
                    headers: { 
                        "Content-Type": "application/x-www-form-urlencoded" 
                    }, 
                    body: 
                        "nome=" + encodeURIComponent(query) + 
                        "&disci=" + encodeURIComponent(disci) 
                }) 
                .then(response => response.json()) 
                .then(dados => { 
 
                    process(dados.map(function(cont){ 
                        return cont.nome; 
                    })); 
 
                    $('#editarCont').data( 
                        'conteudos', 
                        dados 
                    ); 
 
                }) 
                .catch(function(erro){ 
                    console.log(erro); 
                }); 
 
            }, 
 
            minLength: 1, 
            items: 8, 
 
            updater: function(nome){ 
 
                let conteudos = 
                    $('#editarCont').data('conteudos') || []; 
 
                let conteudo = conteudos.find(function(cont){ 
                    return cont.nome == nome; 
                }); 
 
                if(conteudo){ 
                    $('#editarIdCont').val(conteudo.id); 
                } 
 
                return nome; 
 
            } 
 
        }); 
 
 
        $('#editarCont').on('input', function(){ 
            $('#editarIdCont').val(''); 
        }); 
 
 
        $('#abrirEditarDisci').click(function(){ 
 
            $('#novaEditarDisci').val(''); 
 
            $('#modalEditarDisci')[0].showModal(); 
 
        }); 
 
 
        $('#fecharEditarDisci').click(function(){ 
            $('#modalEditarDisci')[0].close(); 
        }); 
 
 
        $('#formEditarDisci').submit(function(event){ 
 
            event.preventDefault(); 
 
            let nome = $('#novaEditarDisci').val().trim(); 
 
            if(nome == ''){ 
                return; 
            } 
 
            fetch("../php/criarDisci.php", { 
                method: "POST", 
                headers: { 
                    "Content-Type": "application/x-www-form-urlencoded" 
                }, 
                body: "nome=" + encodeURIComponent(nome) 
            }) 
            .then(response => response.text()) 
            .then(retorno => { 
 
                let resposta = retorno.trim(); 
 
                if(resposta == "OK!"){ 
 
                    fetch("../php/buscarDisci.php", { 
                        method: "POST", 
                        headers: { 
                            "Content-Type": "application/x-www-form-urlencoded" 
                        }, 
                        body: "nome=" + encodeURIComponent(nome) 
                    }) 
                    .then(response => response.json()) 
                    .then(dados => { 
 
                        let disciplina = dados.find(function(disci){ 
                            return disci.nome == nome; 
                        }); 
 
                        if(disciplina){ 
 
                            $('#editarDisci').val( 
                                disciplina.nome 
                            ); 
 
                            $('#editarIdDisci').val( 
                                disciplina.id 
                            ); 
 
                            $('#editarCont').val(''); 
                            $('#editarIdCont').val(''); 
 
                        } 
 
                    }); 
 
                    $('#novaEditarDisci').val(''); 
 
                    $('#modalEditarDisci')[0].close(); 
 
                    $('#mensagemEditarMaterial').html( 
                        "<p>Disciplina criada com sucesso!</p>" 
                    ); 
 
                } else if(resposta == "EXISTE"){ 
 
                    $('#mensagemEditarMaterial').html( 
                        "<p>Essa disciplina já existe.</p>" 
                    ); 
 
                } else { 
 
                    $('#mensagemEditarMaterial').html( 
                        "<p>Não foi possível criar a disciplina.</p>" 
                    ); 
 
                } 
 
            }) 
            .catch(function(erro){ 
 
                console.log(erro); 
 
                $('#mensagemEditarMaterial').html( 
                    "<p>Erro ao conectar.</p>" 
                ); 
 
            }); 
 
        }); 
 
 
        $('#abrirEditarCont').click(function(){ 
 
            if($('#editarIdDisci').val() == ''){ 
 
                $('#mensagemEditarMaterial').html( 
                    "<p>Selecione uma disciplina primeiro.</p>" 
                ); 
 
                return; 
 
            } 
 
            $('#novoEditarCont').val(''); 
 
            $('#modalEditarCont')[0].showModal(); 
 
        }); 
 
 
        $('#fecharEditarCont').click(function(){ 
            $('#modalEditarCont')[0].close(); 
        }); 
 
 
        $('#formEditarCont').submit(function(event){ 
 
            event.preventDefault(); 
 
            let nome = $('#novoEditarCont').val().trim(); 
            let disci = $('#editarIdDisci').val(); 
 
            if(nome == ''){ 
                return; 
            } 
 
            if(disci == ''){ 
                $('#mensagemEditarMaterial').html( 
                    "<p>Selecione uma disciplina válida.</p>" 
                ); 
                return; 
            } 
 
            fetch("../php/criarCont.php", { 
                method: "POST", 
                headers: { 
                    "Content-Type": "application/x-www-form-urlencoded" 
                }, 
                body: 
                    "nome=" + encodeURIComponent(nome) + 
                    "&disci=" + encodeURIComponent(disci) 
            }) 
            .then(response => response.text()) 
            .then(retorno => { 
 
                let resposta = retorno.trim(); 
 
                if(resposta == "OK!"){ 
 
                    fetch("../php/buscarCont.php", { 
                        method: "POST", 
                        headers: { 
                            "Content-Type": "application/x-www-form-urlencoded" 
                        }, 
                        body: 
                            "nome=" + encodeURIComponent(nome) + 
                            "&disci=" + encodeURIComponent(disci) 
                    }) 
                    .then(response => response.json()) 
                    .then(dados => { 
 
                        let conteudo = dados.find(function(cont){ 
                            return cont.nome == nome; 
                        }); 
 
                        if(conteudo){ 
 
                            $('#editarCont').val( 
                                conteudo.nome 
                            ); 
 
                            $('#editarIdCont').val( 
                                conteudo.id 
                            ); 
 
                        } 
 
                    }); 
 
                    $('#novoEditarCont').val(''); 
 
                    $('#modalEditarCont')[0].close(); 
 
                    $('#mensagemEditarMaterial').html( 
                        "<p>Conteúdo criado com sucesso!</p>" 
                    ); 
 
                } else if(resposta == "EXISTE"){ 
 
                    $('#mensagemEditarMaterial').html( 
                        "<p>Esse conteúdo já existe.</p>" 
                    ); 
 
                } else { 
 
                    $('#mensagemEditarMaterial').html( 
                        "<p>Não foi possível criar o conteúdo.</p>" 
                    ); 
 
                } 
 
            }) 
            .catch(function(erro){ 
 
                console.log(erro); 
 
                $('#mensagemEditarMaterial').html( 
                    "<p>Erro ao conectar.</p>" 
                ); 
 
            }); 
 
        }); 
 
 
        $('#formEditarMaterial').submit(function(event){ 
 
            event.preventDefault(); 
 
            let idMaterial = $('#editarIdMaterial').val(); 
            let titulo = $('#editarTitulo').val().trim(); 
            let idDisci = $('#editarIdDisci').val(); 
            let idCont = $('#editarIdCont').val(); 
            let nivel = $('#editarNivel').val(); 
            let status = $('input[name="editarStatus"]:checked').val(); 
            let descricao = $('#editarDescricao').val().trim(); 
            let arquivo = $('#editarArquivo')[0].files[0]; 
 
            if(titulo == ''){ 
 
                $('#mensagemEditarMaterial').html( 
                    "<p>Digite o título do material.</p>" 
                ); 
 
                return; 
 
            } 
 
            if(idDisci == ''){ 
 
                $('#mensagemEditarMaterial').html( 
                    "<p>Selecione uma disciplina.</p>" 
                ); 
 
                return; 
 
            } 
 
            if(idCont == ''){ 
 
                $('#mensagemEditarMaterial').html( 
                    "<p>Selecione um conteúdo.</p>" 
                ); 
 
                return; 
 
            } 
 
            if(nivel == ''){ 
 
                $('#mensagemEditarMaterial').html( 
                    "<p>Selecione o nível de ensino.</p>" 
                ); 
 
                return; 
 
            } 
 
            if(!status){ 
 
                $('#mensagemEditarMaterial').html( 
                    "<p>Selecione o status do material.</p>" 
                ); 
 
                return; 
 
            } 
 
 
            let dados = new FormData(); 
 
            dados.append("id_material", idMaterial); 
            dados.append("titulo", titulo); 
            dados.append("id_disci", idDisci); 
            dados.append("id_cont", idCont); 
            dados.append("nivel", nivel); 
            dados.append("status", status); 
            dados.append("descricao", descricao); 
 
 
            if(arquivo){ 
 
                dados.append("arquivo", arquivo); 
 
            } 
 
 
            $('#mensagemEditarMaterial').html( 
                "<p>Salvando alterações...</p>" 
            ); 
 
 
            fetch("../php/edtMaterial.php", { 
                method: "POST", 
                body: dados 
            }) 
            .then(response => response.text()) 
            .then(retorno => { 
 
                let resposta = retorno.trim(); 
 
                if(resposta == "OK!"){ 
 
                    $('#mensagemEditarMaterial').html( 
                        "<p>Material atualizado com sucesso!</p>" 
                    ); 
 
                    setTimeout(function(){ 
 
                        $('#modalEditarMaterial')[0].close(); 
 
                        location.reload(); 
 
                    }, 800); 
 
                } else if(resposta == "campos_vazios"){ 
 
                    $('#mensagemEditarMaterial').html( 
                        "<p>Preencha todos os campos obrigatórios.</p>" 
                    ); 
 
                } else if(resposta == "nao_autorizado"){ 
 
                    $('#mensagemEditarMaterial').html( 
                        "<p>Você não pode editar este material.</p>" 
                    ); 
 
                } else if(resposta == "conteudo_invalido"){ 
 
                    $('#mensagemEditarMaterial').html( 
                        "<p>O conteúdo selecionado não pertence à disciplina.</p>" 
                    ); 
 
                } else if(resposta == "erro_tamanho"){ 
 
                    $('#mensagemEditarMaterial').html( 
                        "<p>O arquivo deve ter no máximo 10 MB.</p>" 
                    ); 
 
                } else if(resposta == "erro_extensao"){ 
 
                    $('#mensagemEditarMaterial').html( 
                        "<p>Tipo de arquivo não permitido.</p>" 
                    ); 
 
                } else if(resposta == "erro_upload"){ 
 
                    $('#mensagemEditarMaterial').html( 
                        "<p>Não foi possível enviar o arquivo.</p>" 
                    ); 
 
                } else if(resposta == "erro_arquivo"){ 
 
                    $('#mensagemEditarMaterial').html( 
                        "<p>Erro ao selecionar o arquivo.</p>" 
                    ); 
 
                } else { 
 
                    console.log(resposta); 
 
                    $('#mensagemEditarMaterial').html( 
                        "<p>Erro ao editar o material.</p>" 
                    ); 
 
                } 
 
            }) 
            .catch(function(erro){ 
 
                console.log(erro); 
 
                $('#mensagemEditarMaterial').html( 
                    "<p>Erro ao editar o material.</p>" 
                ); 
 
            }); 
 
        }); 
 
    } 


    if($('#excluirMaterial').length > 0){ 

        $('#excluirMaterial').click(function(){ 

            $('#mensagemExcluirMaterial').html(""); 

            $('#modalExcluirMaterial')[0].showModal(); 

        }); 


        $('#fecharExcluirMaterial').click(function(){ 

            $('#modalExcluirMaterial')[0].close(); 

        }); 


        $('#cancelarExcluirMaterial').click(function(){ 

            $('#modalExcluirMaterial')[0].close(); 

        }); 


        $('#confirmarExcluirMaterial').click(function(){ 

            let idMaterial = $('#excluirMaterial').data('id'); 

            $('#mensagemExcluirMaterial').html( 
                "<p>Excluindo material...</p>" 
            ); 

            fetch("../php/excMaterial.php", { 
                method: "POST", 
                headers: { 
                    "Content-Type": "application/x-www-form-urlencoded" 
                }, 
                body: "id_material=" + encodeURIComponent(idMaterial) 
            }) 
            .then(response => response.text()) 
            .then(retorno => { 

                let resposta = retorno.trim(); 

                if(resposta == "OK!"){ 

                    $('#mensagemExcluirMaterial').html( 
                        "<p>Material excluído com sucesso!</p>" 
                    ); 

                    setTimeout(function(){ 

                        history.back(); 

                    }, 800); 

                } else if(resposta == "nao_autorizado"){ 

                    $('#mensagemExcluirMaterial').html( 
                        "<p>Você não pode excluir este material.</p>" 
                    ); 

                } else if(resposta == "id_invalido"){ 

                    $('#mensagemExcluirMaterial').html( 
                        "<p>Material inválido.</p>" 
                    ); 

                } else if(resposta == "erro_banco"){ 

                    $('#mensagemExcluirMaterial').html( 
                        "<p>Não foi possível excluir o material.</p>" 
                    ); 

                } else { 

                    console.log(resposta); 

                    $('#mensagemExcluirMaterial').html( 
                        "<p>Erro ao excluir o material.</p>" 
                    ); 

                } 

            }) 
            .catch(function(erro){ 

                console.log(erro); 

                $('#mensagemExcluirMaterial').html( 
                    "<p>Erro ao excluir o material.</p>" 
                ); 

            }); 

        }); 

    } 
 
 
    verificarMaterialSalvo(); 
 
});