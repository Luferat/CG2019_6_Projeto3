<?php

/**
 * Página de Contatos
 */

/* Carrega as configurações da página */
require '_config.php';

/* Configura esta página */

// Define o <title></title> desta página.
// Deixe vazio para a 'index'.
$T['pageTitle'] = 'Faça Contato';

// Define as folhas de estilo desta página.
// Deixe vazio para não usar CSS adicional nesta página.
$T['pageCSS'] = '/css/contacts.css';

// Define o JavaScript desta página.
// Deixe vazio para não usar JavaScript adicional nesta página.
$T['pageJS'] = '';

/* Aqui entram todos os seus códigos PHP desta página */

// Define variáveis
$feedback = false;

// Se o formulário foi enviado
if(isset($_POST['contactSend'])) {

    // Obtém e sanitiza valores dos campos
    $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $subject = trim(filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING));
    $message = trim(filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING));

    // Formata SQL
    $sql = "
        INSERT INTO contacts (name, email, subject, message) VALUES
        ('{$name}', '{$email}', '{$subject}', '{$message}');
    ";
    $conn->query($sql);

    // Mostra Feedback
    $feedback = true;
}

/* Aqui terminam todos os seus códigos PHP desta página */

/* Carrega o header e o nav da página */
require '_header.php';

?>

<article>

    <h2><?php echo $T['pageTitle'] ?></h2>

    <?php

    // Exibe formulário se ainda não foi enviado
    if (!$feedback):
    ?>

    <form method="POST" name="contact" id="contact">

        <p>Preencha os campos abaixo para entrar em contato com <?php echo $T['fullSiteName'] ?>.</p>

        <p class="advise">* Todos os campos são obrigatórios.</p>

        <!-- Detecta envio do formulário -->
        <input type="hidden" name="contactSend" value="Ok">

        <p>
            <label for="name">Nome:</label>
            <input type="text" name="name" id="name" required minlength="3" class="valid">
        </p>

        <p>
            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" required class="valid">
        </p>

        <p>
            <label for="subject">Assunto:</label>
            <input type="text" name="subject" id="subject" required minlength="5" class="valid">
        </p>

        <p>
            <label for="message">Mensagem:</label>
            <textarea name="message" id="message" required minlength="5" class="valid"></textarea>
        </p>

        <p>
            <label for="submit"></label>
            <button type="submit" name="submit" id="submit">Enviar</button>
        </p>

    </form>

    <?php

    // Se formulário foi enviado
    else :
    ?>

    <p><strong>Olá <?php echo $name ?>!</strong></p>
    <p>Seu contato foi enviado com sucesso.</p>
    <p><em>Obrigado...</em></p>
    <p class="center">
        <a href="/index.php">
            <i class="fas fa-fw fa-home"></i>
            Página incial
        </a>
    </p>

    <?php
    endif;
    ?>

</article>

<aside>

    <h3>Mais contatos</h3>
    <p>Você pode falar conosco por outros canais:</p>
    <ul>
        <li><a href="#"><i class="fas fa-phone-square fa-fw fa-2x"></i>(21) 9876-54321</a></li>
        <li><a href="#"><i class="fas fa-tools fa-fw fa-2x"></i>(21) 2345-6789</a></li>
        <li><a href="#"><i class="fab fa-whatsapp-square fa-fw fa-2x"></i>(21) 9876-54321</a></li>
        <li><a href="#"><i class="fas fa-envelope-square fa-fw fa-2x"></i>tilojo@tilojo.com</a></li>
    </ul>

    <h3>Redes Sociais</h3>
    <p>Também estamos nas redes sociais:</p>
        <!-- Menu de redes sociais -->
        <ul>

        <?php

        // Lista de redes sociais $T['social']
         foreach($T['social'] as $socialKey => $socialValue) {

                // Primeira letra maiúscula
                $SocialKey = ucfirst($socialKey);

                // Gera lista de redes sociais
                echo <<<HTML
            <li><a href="{$socialValue}" target="_blank" title="{$T['siteName']} no {$SocialKey}."><i class="fab fa-fw fa-{$socialKey}-square fa-2x"></i><span>{$SocialKey}</span></a></li>
HTML;
         }
        
         ?>
        </ul>
</aside>

<?php

require '_footer.php';