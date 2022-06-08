# Qr Code Api System

<!---Esses são exemplos. Veja https://shields.io para outras pessoas ou para personalizar este conjunto de escudos. Você pode querer incluir dependências, status do projeto e informações de licença aqui--->

![GitHub repo size](https://img.shields.io/github/repo-size/Paulo-2048/qrcode-api?style=for-the-badge) ![GitHub language count](https://img.shields.io/github/languages/count/Paulo-2048/qrcode-api?style=for-the-badge) ![GitHub forks](https://img.shields.io/github/forks/Paulo-2048/qrcode-api?style=for-the-badge)

<img src="https://static.beaconstac.com/assets/img/navheader_qr_code.png" alt="exemplo imagem">

> Apenas o esqueleto do projeto está pronto, é importante uma refatoração para otimização e organização do código, e a API não foi lançada no servidor ainda, nem o banco de dados está online

### Ajustes e melhorias

O projeto ainda está em desenvolvimento e as próximas atualizações serão voltadas nas seguintes tarefas:

- [x] Conexão com banco de dados.
- [x] Separação em classes específicas, para aplicar eventuais regras de negócios.
- [x] Endpoints de Qrcode e de usuários prontos.
- [ ] Lançar no servidor, juntamente com banco de dados online.
- [ ] Refatoração e etapa de testes.
- [ ] Detalhar utilização dos endpoints.

## 💻 Sobre o projeto

Em resumo, o projeto consiste em uma api construída em PHP (Sem frameworks) e MySQL, onde é possível fazer um CRUD básico tanto de usuários como de QR Codes gerados (Mas na frente falarei mais sobre cada um e seus respectivos endpoints).

Caso você queira replicar esse projeto, esses são alguns pré-requisitos, baseados em como a Api foi construída (Pode funcionar de outras formas)

- `XAMMP v3.3.0`
- `PHP v8.1.6`
- `MySQL v8.0.27`

## 🚀 Replicando

Para replicar o projeto, siga estas etapas:

1. Clone este repositório para sua máquina local.
2. Execute o arquivo Databse.sql, para criar o o banco e tabelas necessárias.
3. Inicie o servidor Apache
4. Acesse o index.php e suas devidas rotas

## ☕ Endpoints

Abaixo estão descritos os endpoints:

###### Endpoints Usuários

- login
- setuser
- getusers
- updateuser
- deleteuser

###### Endpoints QR Codes

- getqrcodes
- setqrcode
- updateqrcode
- deleteqrcode
- redirect

Cada um dos endpoints serão detalhados posteriormente, mas caso haja alguma dúvida não hesite em me perguntar aqui no Github ou pelo [Linkdin](https://www.linkedin.com/in/paulo-2048/ "Linkdin")

## 📫 Contribuindo para <nome_do_projeto>

<!---Se o seu README for longo ou se você tiver algum processo ou etapas específicas que deseja que os contribuidores sigam, considere a criação de um arquivo CONTRIBUTING.md separado--->

Para contribuir, siga estas etapas:

1. Bifurque este repositório.
2. Crie um branch: `git checkout -b <nome_branch>`.
3. Faça suas alterações e confirme-as: `git commit -m '<mensagem_commit>'`
4. Envie para o branch original: `git push origin <nome_do_projeto> / <local>`
5. Crie a solicitação de pull.

Como alternativa, consulte a documentação do GitHub em [como criar uma solicitação pull](https://help.github.com/en/github/collaborating-with-issues-and-pull-requests/creating-a-pull-request).

<!---
## 🤝 Colaboradores

Agradecemos às seguintes pessoas que contribuíram para este projeto:

<table>
  <tr>
    <td align="center">
      <a href="#">
        <img src="https://avatars3.githubusercontent.com/u/31936044" width="100px;" alt="Foto do Iuri Silva no GitHub"/><br>
        <sub>
          <b>Iuri Silva</b>
        </sub>
      </a>
    </td>
    <td align="center">
      <a href="#">
        <img src="https://s2.glbimg.com/FUcw2usZfSTL6yCCGj3L3v3SpJ8=/smart/e.glbimg.com/og/ed/f/original/2019/04/25/zuckerberg_podcast.jpg" width="100px;" alt="Foto do Mark Zuckerberg"/><br>
        <sub>
          <b>Mark Zuckerberg</b>
        </sub>
      </a>
    </td>
    <td align="center">
      <a href="#">
        <img src="https://miro.medium.com/max/360/0*1SkS3mSorArvY9kS.jpg" width="100px;" alt="Foto do Steve Jobs"/><br>
        <sub>
          <b>Steve Jobs</b>
        </sub>
      </a>
    </td>
  </tr>
</table>

--->

## 😄 Seja um dos contribuidores<br>

Quer fazer parte desse projeto? Clique [AQUI](CONTRIBUTING.md) e leia como contribuir.
<!---
## 📝 Licença

Esse projeto está sob licença. Veja o arquivo [LICENÇA](LICENSE.md) para mais detalhes.
--->

[⬆ Voltar ao topo](#nome-do-projeto)<br>
