# BarberManager

O BarberManager é um sistema de gerenciamento de barbearia, visando auxiliar o barbeiro e/ou seu administrador a controlar todos os fluxos de atendimento barbearia, podendo ter um controle dos serviços, os valores de cada um, as datas e o lucro diário, semanal, mensal, etc.

# Tecnologias Utilizadas
* PHP
* Laravel
* MySQL

# Endpoints
1. Criar um novo barbeiro
   ° Método: POST
   ° Rota: http://127.0.0.1:8000/api/barber
   ° Exemplo de JSON:
```json
{
  "name": "Ronaldo Justino",
  "telephone": "71987111234",
   "status": "Disponível"
}
