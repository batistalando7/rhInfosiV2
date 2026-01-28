<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico do Funcionário</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }

        .photo {
            flex: 0 0 200px;
            margin-right: 20px;
        }

        .photo img {
            width: 100%;
            height: auto;
            border-radius: 50%;
            border: 2px solid #ccc;
        }

        .personal-data {
            flex: 1;
        }

        .personal-data h1 {
            margin-top: 0;
        }

        .section {
            margin-bottom: 20px;
        }

        .section h2 {
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        ul {
            list-style-type: disc;
            padding-left: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="photo">
                <img src="{{ asset('frontend/images/departments/' . $employee->photo)}}" alt="Foto do Funcionário">
            </div>
            <div class="personal-data">
                <h1>Nome do Funcionário: João Silva</h1>
                <p><strong>Data de Nascimento:</strong> 15/05/1985</p>
                <p><strong>Endereço:</strong> Rua Exemplo, 123, Luanda, Angola</p>
                <p><strong>Contato:</strong> +244 999 999 999</p>
                <p><strong>Email:</strong> joao.silva@empresa.com</p>
                <p><strong>Data de Admissão:</strong> 01/01/2010</p>
            </div>
        </div>

        <div class="section">
            <h2>Departamento Atual e Histórico</h2>
            <ul>
                <li><strong>Departamento Atual:</strong> Recursos Humanos (desde 01/01/2020)</li>
                <li>Departamento de Vendas (01/01/2015 a 31/12/2019)</li>
                <li>Departamento de Marketing (01/01/2010 a 31/12/2014)</li>
            </ul>
        </div>

        <div class="section">
            <h2>Cargos Ocupados</h2>
            <ul>
                <li>Gerente de RH (2020 - Presente)</li>
                <li>Supervisor de Vendas (2015 - 2019)</li>
                <li>Assistente de Marketing (2010 - 2014)</li>
            </ul>
        </div>

        <div class="section">
            <h2>Férias</h2>
            <ul>
                <li>2023: 15 dias (01/07/2023 a 15/07/2023)</li>
                <li>2022: 30 dias (01/06/2022 a 30/06/2022)</li>
                <li>2021: 20 dias (15/08/2021 a 04/09/2021)</li>
            </ul>
        </div>

        <div class="section">
            <h2>Licenças</h2>
            <ul>
                <li>Licença Médica: 10 dias (05/03/2022 a 14/03/2022)</li>
                <li>Licença Paternidade: 5 dias (20/11/2018 a 24/11/2018)</li>
            </ul>
        </div>

        <div class="section">
            <h2>Mobilidade</h2>
            <p>Transferências internas ou mudanças de localização:</p>
            <ul>
                <li>Transferido para filial em Luanda (01/01/2015)</li>
                <li>Mudança para sede principal (01/01/2020)</li>
            </ul>
        </div>

        <div class="section">
            <h2>Destacamentos</h2>
            <p>Períodos de destacamento para projetos especiais:</p>
            <ul>
                <li>Projeto Internacional: 3 meses (01/04/2017 a 30/06/2017)</li>
                <li>Destacamento Regional: 1 mês (15/09/2021 a 14/10/2021)</li>
            </ul>
        </div>

        <div class="section">
            <h2>Trabalhos Extras</h2>
            <ul>
                <li>Horas extras: 50 horas em 2023</li>
                <li>Projetos adicionais: Consultoria interna em 2022 (20 horas)</li>
            </ul>
        </div>

        <div class="section">
            <h2>Mapa de Efetividade (Faltas e Presenças)</h2>
            <table>
                <thead>
                    <tr>
                        <th>Ano</th>
                        <th>Dias Trabalhados</th>
                        <th>Faltas Justificadas</th>
                        <th>Faltas Injustificadas</th>
                        <th>Presenças Totais</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2023</td>
                        <td>250</td>
                        <td>5</td>
                        <td>0</td>
                        <td>255</td>
                    </tr>
                    <tr>
                        <td>2022</td>
                        <td>240</td>
                        <td>10</td>
                        <td>2</td>
                        <td>252</td>
                    </tr>
                    <tr>
                        <td>2021</td>
                        <td>245</td>
                        <td>8</td>
                        <td>1</td>
                        <td>254</td>
                    </tr>
                    <!-- Adicione mais linhas conforme necessário para o período completo -->
                </tbody>
            </table>
        </div>

        <div class="section">
            <h2>Último Salário Pago</h2>
            <p><strong>Valor:</strong> 5.000.000 AOA</p>
            <p><strong>Data do Pagamento:</strong> 31/12/2023</p>
        </div>
    </div>
</body>
</html>