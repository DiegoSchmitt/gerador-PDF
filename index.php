<table>
  <thead>
    <tr>
      <th>Nome</th>
      <th>Idade</th>
      <th>Cidade</th>
    </tr>
  </thead>
  <tbody>
    <?php 


		$nomes = ['Maria Silva', 'João Souza', 'Ana Oliveira', 'Pedro Santos', 'Carla Alves', 'Lucas Pereira', 'Fernanda Ribeiro', 'Rodrigo Barbosa', 'Laura Martins', 'Diego Costa', 'Gustavo Ferreira', 'Isabela Rodrigues', 'Mariana Santos da Silva', 'Rafaela Costa e Silva', 'Camila Almeida de Oliveira', 'Felipe Oliveira Souza', 'Natália Pereira da Costa', 'Thiago Ribeiro de Oliveira', 'Eduardo Martins dos Santos', 'Juliana Rodrigues da Silva', 'Marcelo Alves Pereira', 'Amanda Costa e Souza', 'Vinicius Oliveira Ribeiro', 'Caroline Santos de Almeida', 'Luana Martins de Oliveira', 'Renato Barbosa dos Santos', 'Cristina Ribeiro Almeida', 'Leonardo Souza da Silva', 'Larissa Costa e Oliveira', 'Fábio Rodrigues Alves', 'Patrícia Martins Pereira', 'Daniel Santos da Costa', 'Paula Oliveira de Almeida', 'Luciana Ribeiro dos Santos', 'Victor Alves da Silva', 'Vanessa Costa e Souza', 'Raquel Oliveira Ribeiro', 'Hugo Santos de Almeida', 'Lucas Martins da Costa', 'Giovana Ribeiro Alves', 'Matheus Souza de Oliveira', 'Gabriela Pereira dos Santos', 'Samuel Almeida da Silva', 'Isadora Martins Costa e Souza', 'Roberto Oliveira Ribeiro', 'Simone Santos de Almeida', 'Francisco Ribeiro Martins', 'Sara Oliveira Costa e Silva'];

		$cidades = ['São Paulo', 'Rio de Janeiro', 'Belo Horizonte', 'Curitiba', 'Porto Alegre', 'Recife', 'Fortaleza', 'Salvador', 'Brasília', 'Belém', 'Manaus', 'Goiânia', 'Florianópolis', 'Vitória', 'Campo Grande', 'Cuiabá', 'João Pessoa', 'Aracaju', 'Maceió', 'Natal'];

		$registros = [];

		for ($i = 0; $i < 200; $i++) {
			$nome = $nomes[rand(0, count($nomes) - 1)];
			$idade = rand(18, 60);
			$cidade = $cidades[rand(0, count($cidades) - 1)];

			$registros[] = ['nome' => $nome, 'idade' => $idade, 'cidade' => $cidade];
		}


	
	foreach($registros as $registro): ?>
      <tr>
        <td><?= $registro['nome']; ?></td>
        <td><?= $registro['idade']; ?></td>
		<td><?= $registro['cidade']; ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<form action="gerar_pdf.php" method="post" target="_blank">
  <input type="hidden" name="registros" value="<?= htmlspecialchars(json_encode($registros)); ?>">
  <button type="submit">Enviar</button>
</form>
