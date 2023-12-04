document.onload = gerenciarMenu();

function gerenciarMenu(){
    var indAtual = document.getElementById('actualIndex').value;

    switch(indAtual){
      case 'dashboard':
        $('#indexEstoque').removeClass('active');
        $('#indexEmprestimos').removeClass('active');
        $('#indexColaboradores').removeClass('active');
        $('#indexUsuarios').removeClass('active');

        $('#indexDashboard').addClass('active');
        break;
      case 'estoque':
        $('#indexDashboard').removeClass('active');
        $('#indexEmprestimos').removeClass('active');
        $('#indexColaboradores').removeClass('active');
        $('#indexUsuarios').removeClass('active');

        $('#indexEstoque').addClass('active');
        break;
      case 'emprestimos':
        $('#indexEstoque').removeClass('active');
        $('#indexDashboard').removeClass('active');
        $('#indexColaboradores').removeClass('active');
        $('#indexUsuarios').removeClass('active');

        $('#indexEmprestimos').addClass('active');
        break;
      case 'colaboradores':
        $('#indexEstoque').removeClass('active');
        $('#indexEmprestimos').removeClass('active');
        $('#indexDashboard').removeClass('active');
        $('#indexUsuarios').removeClass('active');

        $('#indexColaboradores').addClass('active');
        break;
      case 'usuarios':
        $('#indexEstoque').removeClass('active');
        $('#indexEmprestimos').removeClass('active');
        $('#indexColaboradores').removeClass('active');
        $('#indexDashboard').removeClass('active');

        $('#indexUsuarios').addClass('active');
        break;
    }
  }