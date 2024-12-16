# BarberManager

O BarberManager é um sistema de gerenciamento de barbearia, visando auxiliar o barbeiro e/ou seu administrador a controlar todos os fluxos de atendimento barbearia, podendo ter um controle dos serviços, os valores de cada um, as datas e o lucro diário, semanal, mensal, etc.

# Tecnologias Utilizadas
* PHP
* Laravel
* MySQL

# Endpoints

## Barbeiros
1. Listar todos os barbeiros
   - **Método:** GET
   - **Rota:** http://127.0.0.1:8000/api/barber

2. Listar um barbeiro em específico
   - **Método:** GET
   - **Rota:** http://127.0.0.1:8000/api/barber/{id}
   
3. Criar um novo barbeiro
   - **Método:** POST
   - **Rota:** http://127.0.0.1:8000/api/barber
   - **Exemplo JSON:**
    ```json
    {
      "name": "Ronaldo Justino",
      "telephone": "71987111234",
       "status": "Disponível"
    }

4. Atualizar um barbeiro
   - **Método:** PUT
   - **Rota:** http://127.0.0.1:8000/api/barber/{id}
   - **Exemplo JSON:**
    ```json
    {
      "name": "Ronaldo Fênomeno",
      "telephone": "71987111234",
       "status": "Disponível"
    }

5. Deletar um barbeiro
   - **Método:** DELETE
   - **Rota:** http://127.0.0.1:8000/api/barber/{id}


## Clientes

1. Listar todos os clientes
     - **Método:** GET
     - **Rota:** http://127.0.0.1:8000/api/client

2. Listar um cliente em específico
   - **Método:** GET
   - **Rota:** http://127.0.0.1:8000/api/client/{id}

3. Criar um novo cliente
   - **Método:** POST
   - **Rota:** http://127.0.0.1:8000/api/client
   - **Exemplo JSON:**
    ```json
    {
      "name": "Elder",
	  "telephone": "71986987120",
	  "address": "Rua do Chafariz, 312",
	  "birthDate": "2002-07-18"
    }

4. Atualizar um cliente
   - **Método:** PUT
   - **Rota:** http://127.0.0.1:8000/api/client/{id}
   - **Exemplo JSON:**
    ```json
    {
      "name": "Elder Borges",
	  "telephone": "71986987120",
	  "address": "Rua do Chafariz, 312",
	  "birthDate": "2002-07-18"
    }
5. Deletar um cliente
   - **Método:** DELETE
   - **Rota:** http://127.0.0.1:8000/api/client/{id}
  
## Agendamentos
1. Listar todos os agendamentos
    - **Método:** GET
    - **Rota:** http://127.0.0.1:8000/api/schedulling

2. Listar um agendamento em específico
   - **Método:** GET
   - **Rota:** http://127.0.0.1:8000/api/schedulling/{id}
  
3. Criar um novo agendamento
   - **Método:** POST
   - **Rota:** http://127.0.0.1:8000/api/schedulling
   - **Exemplo JSON:**
    ```json
    {
      "barber_id": 6,
      "client_id": 2,
      "categories": [1,2],
      "serviceTime": "2024-12-18 18:00:00",
      "payment": "Pix",
      "status": "Em andamento"
    }
    
4. Atualizar um agendamento
   - **Método:** PUT
   - **Rota:** http://127.0.0.1:8000/api/schedulling/{id}
   - **Exemplo JSON:**
    ```json
    {
      "barber_id": 6,
      "client_id": 2,
      "categories": [1,2],
      "serviceTime": "2024-12-18 18:00:00",
      "payment": "Débito",
      "status": "Em andamento"
    }

5. Deletar um agendamento
   - **Método:** DELETE
   - **Rota:** http://127.0.0.1:8000/api/schedulling/{id}
