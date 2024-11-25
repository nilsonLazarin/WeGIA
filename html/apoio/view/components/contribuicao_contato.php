<div class="wrap-input100">
    <label for="nome" class="label-input100">Nome <span class="obrigatorio">*</span></label>
    <input type="text" class="input100" name="nome" id="nome" placeholder="Informe seu nome completo">
</div>
<div class="wrap-input100">
    <label for="data_nascimento" class="label-input100">Data de Nascimento <span class="obrigatorio">*</span></label>
    <input type="date" class="input100" name="data_nascimento" id="data_nascimento" min="1900-01-01" max="<?= date('Y-m-d') ?>">
</div>
<div class="wrap-input100">
    <label for="email" class="label-input100">E-mail <span class="obrigatorio">*</span></label>
    <input type="text" class="input100" name="email" id="email" placeholder="Informe seu e-mail">
</div>
<div class="wrap-input100">
    <label for="telefone" class="label-input100">Telefone <span class="obrigatorio">*</span></label>
    <input type="text" class="input100" name="telefone" id="telefone" placeholder="Informe seu número de telefone para contato" onkeypress="mascara('(##)#####-####',this,event); return Onlynumbers(event)" maxlength="14">
</div>
<div class="container-contact100-form-btn">
    <button class="contact100-form-btn btn-acao" id="avanca-contato">
        AVANÇAR
        <i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
    </button>

    <div class="container-contact100-form-btn">
        <button class="contact100-form-btn btn-voltar" id="volta-cpf">
            <i style="margin-right: 15px; " class="fa fa-long-arrow-left m-l-7" aria-hidden="true"></i>
            VOLTAR
        </button>
    </div>
</div>