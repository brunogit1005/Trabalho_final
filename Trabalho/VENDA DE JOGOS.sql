DROP DATABASE IF EXISTS JOGOS;
CREATE DATABASE IF NOT EXISTS JOGOS;
USE JOGOS;

CREATE TABLE IF NOT EXISTS CLASSIFICACAO (
    ID_CLASSIFICACAO INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    CLASSI_INDICATIVA VARCHAR(10)
);

CREATE TABLE IF NOT EXISTS GENERO(
    ID_GENERO INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    TIPO VARCHAR(10)
);

CREATE TABLE IF NOT EXISTS LINGUAGEM(
    ID_LINGUAGEM INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    IDIOMA VARCHAR(10)
);




CREATE TABLE IF NOT EXISTS JOGO (
    ID_JOGO INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    ID_CLASSIFICACAO INT,
    ID_GENERO INT,
    ID_LINGUAGEM INT,
    NOME_JOGO VARCHAR(40),
    PRECO FLOAT (22, 2),	
    AVALIACAO INT (2),
    EMPRESA VARCHAR(40),
    DESCRICAO VARCHAR(1000),
    FOREIGN KEY (ID_CLASSIFICACAO)
    REFERENCES CLASSIFICACAO (ID_CLASSIFICACAO)
     ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (ID_GENERO)
    REFERENCES GENERO (ID_GENERO)
     ON UPDATE CASCADE ON DELETE CASCADE,
     FOREIGN KEY (ID_LINGUAGEM)
    REFERENCES LINGUAGEM (ID_LINGUAGEM)
     ON UPDATE CASCADE ON DELETE CASCADE
    
    
);
CREATE TABLE IF NOT EXISTS USUARIO (
    ID_USUARIO INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	NOME VARCHAR(35),
    SENHA VARCHAR (40),
    DATA_NASC DATE,
	RG VARCHAR (15),
    CPF INT(11),
    CIDADE VARCHAR(25),
    ENDERECO VARCHAR(40),
    PERMISSAO INT(1),
    TELEFONE INT(25),
    LOGIN VARCHAR(30)
);

select *
from usuario;
CREATE TABLE IF NOT EXISTS COMPRA (
    ID_COMPRA INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	NUM_CARTAO INT(15),
    NUM_BOLETO INT(15),
    MODO_PAGAMENTO VARCHAR(20),
    ID_USUARIO INT,
     FOREIGN KEY (ID_USUARIO)
        REFERENCES USUARIO (ID_USUARIO)
        ON UPDATE CASCADE ON DELETE CASCADE


);

CREATE TABLE IF NOT EXISTS COMPRA_JOGO (
    ID_COMPRA_JOGO INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	ID_COMPRA INT(10),
    ID_JOGO INT(10),
     FOREIGN KEY (ID_COMPRA)
        REFERENCES COMPRA (ID_COMPRA)
        ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (ID_JOGO)
        REFERENCES JOGO(ID_JOGO)
        ON UPDATE CASCADE ON DELETE CASCADE

);






SHOW TABLES;


INSERT INTO CLASSIFICACAO VALUES (1,'18');
INSERT INTO CLASSIFICACAO VALUES (2,'16');
INSERT INTO CLASSIFICACAO VALUES (3,'14');
INSERT INTO CLASSIFICACAO VALUES (4,'12');
INSERT INTO CLASSIFICACAO VALUES (5,'10');
INSERT INTO CLASSIFICACAO VALUES (6,'L');

INSERT INTO GENERO VALUES (1,'RPG');
INSERT INTO GENERO VALUES (2,'AVENTURA');
INSERT INTO GENERO VALUES (3,'SPORT');
INSERT INTO GENERO VALUES (4,'TERROR');
INSERT INTO GENERO VALUES (5,'LUTA');
INSERT INTO GENERO VALUES (6,'ESTRATEGIA');
INSERT INTO GENERO VALUES (7,'CORRIDA');
INSERT INTO GENERO VALUES (8,'FPS');


INSERT INTO LINGUAGEM VALUES (1,'PORTUGUES');
INSERT INTO LINGUAGEM VALUES (2,'ESPANHOL');
INSERT INTO LINGUAGEM VALUES (3,'INGLES');
INSERT INTO LINGUAGEM VALUES (4,'FRANCÊS');
INSERT INTO LINGUAGEM VALUES (5,'ITALIANO');
INSERT INTO LINGUAGEM VALUES (6,'ALEMÃO');
INSERT INTO LINGUAGEM VALUES (7,'HOLANDES');



SELECT *
FROM JOGO;

INSERT INTO JOGO VALUES (1,1,1,1,'AVENGERS',150.00,7,'TELLTALE GAMES','Reúna sua equipe dos Super-Heróis mais Poderosos da Terra, assuma seus poderes e realize seus sonhos de Super-Herói.');
INSERT INTO JOGO VALUES (2,1,1,1,'DRAGON BALL Z KAKAROT',200.00,8,'BANDAI NAMCO','Reviva a história de Goku em DRAGON BALL Z: KAKAROT! Vá além das batalhas épicas e viva no mundo de DRAGON BALL Z lutando, pescando, comendo e treinando com Goku.');
INSERT INTO JOGO VALUES (3,1,1,1,'FIFA 20',150.00,10,'EA','Desenvolvido com o Frostbite™, o EA SPORTS™ FIFA 20 para PlayStation®4 dá vida aos dois universos do jogo mais popular do mundo: o glamour das partidas profissionais e uma experiência nova e autêntica de futebol de rua em EA SPORTS VOLTA.');
INSERT INTO JOGO VALUES (4,1,1,1,'FINAL FANTASY',300.00,9,'SQUARE ENIX','O mundo acabou sendo controlado pela Shinra Electric Power Company, uma empresa misteriosa que detém a força da vida do nosso planeta, conhecida como energia mako.
 
Na grande cidade de Midgar, uma organização que se opõe à Shinra, chamada Avalanche, intensificou sua resistência. O grupo recebe a ajuda de Cloud Strife, ex-membro da unidade de elite SOLDIER da Shinra que passou a ser um mercenário, sem saber da magnitude das consequências que o aguardam.');

INSERT INTO JOGO VALUES (5,1,1,1,'LOST EMBER',100.00,8,'ARMOR GAMES','Experimente duas histórias contrastantes como loba e mais de uma dúzia de outros animais, pois você tem a habilidade especial de se transformar em qualquer animal que encontrar no mundo exuberante e pós-apocalíptico de Lost Ember. Junto com seu companheiro, você embarca em uma jornada para descobrir o que aconteceu com a humanidade há muito tempo, antes de a natureza retomar o mundo.');

INSERT INTO JOGO VALUES (6,1,1,1,'MONSTER HUNTER',150.00,9,'UBISOFT','Começando exatamente onde Monster Hunter: World parou, Iceborne leva o seu caçador e a Comissão de Pesquisa a Hoarfrost Reach, uma nova região polar repleta de criaturas nunca antes vistas. Use sua inteligência, seus equipamentos e novas habilidades para sobreviver nesse lugar inóspito.');

INSERT INTO JOGO VALUES (7,1,1,1,'NEED FOR SPEED',150.00,10.0,'ACTVISION','Dark Souls se passa primariamente no reino fictício de Lordran, onde os jogadores assumem o papel de um personagem denominado Chosen Undead que, segundo lendas, seria responsável pela quebra de uma maldição que torna incapazes de morrer aqueles que são afligidos por uma misteriosa marca negra. O jogo é inspirado fortemente pela temática medieval, com a presença de deuses e seres fantásticos, inseridos em um mundo decadente e punitivo. A estrutura de apresentação da história é subjetiva, dando-se basicamente através da descrição de itens ou em interações com NPCs, possibilitando margem para diversas interpretações acerca de toda a mitologia presente no jogo.');

INSERT INTO JOGO VALUES (8,1,1,1,'NIOH 2',200.00,10,'FROMSOFTWARE','Domine a arte fatal dos samurais controlando um guerreiro Yokai que é meio humano e meio sobrenatural na continuação desafiadora desse RPG de ação.
Explore o violento Japão do período Sengoku e o Reino Sombrio mortal, ambos repletos de demônios grotescos e implacáveis.');

INSERT INTO JOGO VALUES (9,1,1,1,'REBORN',150.00,16,'ARMOR GAMES','Reborn: A Samurai Awakens é um jogo de ação e aventura em RV em primeira pessoa que combina robôs, samurais e lutas de espada. O jogador é um samurai que foi ressuscitado por uma tecnologia do futuro para enfrentar invasores robóticos.');

INSERT INTO JOGO VALUES (10,1,1,1,'SPIRIT OF THE NORTH',100.00,10,'SQUARE ENIX','Jogue como uma raposa-vermelha comum cuja história se entrelaça com o guardião da Northern Lights, uma raposa fêmea espiritual. Durante seu caminho pelas montanhas e sob céus tingidos de vermelho, você descobrirá mais sobre sua companheira e uma terra em ruínas.');


SELECT *
FROM USUARIO;

INSERT INTO USUARIO VALUES (1,'JOAO','123','2001-10-31','1234567890',98765432,'ARARAQUARA','RUA JOSE DE ARRUDA FALCAO',2,988332832,'JOAO@GMAIL');
INSERT INTO USUARIO VALUES (2,'EDUARDO','321','2010-11-30','79854346',54343587,'ARARAQUARA','JARDIM SAO RAFAEL',1,64545483,'EDUARDO@GMAIL');
INSERT INTO USUARIO VALUES (3,'BRUNO','4321','2002-10-30','54231319',47235464,'ARARAQUARA','RUA TRAB DO FON',1,97854334,'BRUNO@GMAIL');

SELECT *
FROM COMPRA;

INSERT INTO COMPRA VALUES (1,1234567, 'Cartão', 1);
INSERT INTO COMPRA VALUES (2,1231456, 'Cartão', 2);
INSERT INTO COMPRA VALUES (3,2132133, 'Cartão', 3);




