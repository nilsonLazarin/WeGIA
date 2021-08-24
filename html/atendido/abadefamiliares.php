

                <!-- Aba Familiares -->
                <div id="familiares" class="tab-pane">
                  <section class="panel">
                    <header class="panel-heading">
                      <div class="panel-actions">
                        <a href="#" class="fa fa-caret-down"></a>
                      </div>
                      <h2 class="panel-title">Dependentes</h2>
                    </header>
                    <div class="panel-body">
                      <table class="table table-bordered table-striped mb-none" id="datatable-dependente">
                        <thead>
                          <tr>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Parentesco</th>
                            <th>Ação</th>
                          </tr>
                        </thead>
                        <tbody id="dep-tab">

                        </tbody>
                      </table>
                      <br>
                      <!-- Button trigger modal -->
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#depFormModal">
                        Adicionar Dependente
                      </button>
                    </div>

                    <!-- Modal Form Dependentes -->
                    <div class="modal fade" id="depFormModal" tabindex="-1" role="dialog" aria-labelledby="depFormModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header" style="display: flex;justify-content: space-between;">
                            <h5 class="modal-title" id="exampleModalLabel">Adicionar Dependente</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form action='./funcionario/dependente_cadastrar.php' method='post' id='funcionarioDepForm'>
                            <div class="modal-body" style="padding: 15px 40px">
                              <div class="form-group" style="display: grid;">
                                <h4 class="mb-xlg">Informações Pessoais</h4>
                                <h5 class="obrig">Campos Obrigatórios(*)</h5>
                                <div class="form-group">
                                  <label class="col-md-3 control-label" for="profileFirstName">Nome<sup class="obrig">*</sup></label>
                                  <div class="col-md-8">
                                    <input type="text" class="form-control" name="nome" id="profileFirstName" id="nome" onkeypress="return Onlychars(event)" required>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-md-3 control-label">Sobrenome<sup class="obrig">*</sup></label>
                                  <div class="col-md-8">
                                    <input type="text" class="form-control" name="sobrenome" id="sobrenome" onkeypress="return Onlychars(event)" required>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-md-3 control-label" for="profileLastName">Sexo<sup class="obrig">*</sup></label>
                                  <div class="col-md-8">
                                    <label><input type="radio" name="sexo" id="radio" id="M" value="m" style="margin-top: 10px; margin-left: 15px;" onclick="return exibir_reservista()" required><i class="fa fa-male" style="font-size: 20px;"></i></label>
                                    <label><input type="radio" name="sexo" id="radio" id="F" value="f" style="margin-top: 10px; margin-left: 15px;" onclick="return esconder_reservista()"><i class="fa fa-female" style="font-size: 20px;"></i> </label>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-md-3 control-label" for="telefone">Telefone</label>
                                  <div class="col-md-8">
                                    <input type="text" class="form-control" maxlength="14" minlength="14" name="telefone" id="telefone" id="telefone" placeholder="Ex: (22)99999-9999" onkeypress="return Onlynumbers(event)" onkeyup="mascara('(##)#####-####',this,event)">
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-md-3 control-label" for="profileCompany">Nascimento<sup class="obrig">*</sup></label>
                                  <div class="col-md-8">
                                    <input type="date" placeholder="dd/mm/aaaa" maxlength="10" class="form-control" name="nascimento" id="nascimento" max=<?php echo date('Y-m-d'); ?> required>
                                  </div>
                                </div>
                                <hr class="dotted short">
                                <h4 class="mb-xlg doch4">Documentação</h4>
                                <div class="form-group">
                                  <label class="col-md-3 control-label" for="cpf">Número do CPF<sup class="obrig">*</sup></label>
                                  <div class="col-md-6">
                                    <input type="text" class="form-control" id="cpf" id="cpf" name="cpf" placeholder="Ex: 222.222.222-22" maxlength="14" onblur="validarCPF(this.value)" onkeypress="return Onlynumbers(event)" onkeyup="mascara('###.###.###-##',this,event)" required>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-md-3 control-label" for="profileCompany"></label>
                                  <div class="col-md-6">
                                    <p id="cpfInvalido" style="display: none; color: #b30000">CPF INVÁLIDO!</p>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-md-3 control-label" for="parentesco">Parentesco<sup class="obrig">*</sup></label>
                                  <div class="col-md-6" style="display: flex;">
                                    <select name="id_parentesco" id="parentesco">
                                      <option selected disabled>Selecionar...</option>
                                      <?php
                                      foreach ($pdo->query("SELECT * FROM funcionario_dependente_parentesco ORDER BY descricao ASC;")->fetchAll(PDO::FETCH_ASSOC) as $item) {
                                        echo ("
                                            <option value='" . $item["id_parentesco"] . "' >" . $item["descricao"] . "</option>
                                            ");
                                      }
                                      ?>
                                    </select>
                                    <a onclick="adicionarParentesco()" style="margin: 0 20px;"><i class="fas fa-plus w3-xlarge" style="margin-top: 0.75vw"></i></a>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-md-3 control-label" for="profileCompany">Número do RG</label>
                                  <div class="col-md-6">
                                    <input type="text" class="form-control" name="rg" id="rg" onkeypress="return Onlynumbers(event)" placeholder="Ex: 22.222.222-2" onkeyup="mascara('##.###.###-#',this,event)">
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-md-3 control-label" for="profileCompany">Órgão Emissor</label>
                                  <div class="col-md-6">
                                    <input type="text" class="form-control" name="orgao_emissor" id="profileCompany" id="orgao_emissor" onkeypress="return Onlychars(event)">
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-md-3 control-label" for="profileCompany">Data de expedição</label>
                                  <div class="col-md-6">
                                    <input type="date" class="form-control" maxlength="10" placeholder="dd/mm/aaaa" id="profileCompany" name="data_expedicao" id="data_expedicao" max=<?php echo date('Y-m-d'); ?>>
                                  </div>
                                </div>
                                <input type="hidden" name="id_funcionario" value="<?= $_GET['id_funcionario']; ?>" readonly>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                  <input type="submit" value="Enviar" class="btn btn-primary">
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </section>
                </div>
                        