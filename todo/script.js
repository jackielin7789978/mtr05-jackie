/* eslint-env jquery */
$(document).ready(() => {
  // 初始畫面：隱藏所有 todos
  if ($('#putCardHere').find('li').length === 0) {
    $('.card').hide()
  }
  // 新增功能
  $('#submit-form').on('submit', (e) => {
    e.preventDefault()
    const input = $('#input').val()
    if (!input) {
      alert('請輸入待辦事項')
    } else {
      $('.card').show()
      const todo = $('#input').val()
      $('#putCardHere').append(`
        <li class="list-group-item d-flex flex-row align-items-center justify-content-between pending">
          <div class="d-flex flex-row align-items-center">
            <div class="pretty p-default p-round p-thick mb-2">
              <input class="custom-checkbox" type="checkbox" />
              <div class="state">
                <label class="fs-5 todo-item"></label>
              </div>
            </div>
            <div class="fs-5 todo__taskname">${escapeXSS(todo)}</div>
            <form class="edit-form">
              <input class="todo__taskname--edit" type="text">
            </form>
          </div>
          <div class="todo__btns">
            <button class="btn btn-outline-secondary btn-edit">Edit</button>
            <button class="btn btn-outline-secondary btn-remove">Remove</button>
          </div>
        </li>
      `)
      $('.edit-form').hide()
      $('#input').val('')
    }
  })
  // 編輯功能
  $('#putCardHere').on('click', '.btn-edit', (e) => {
    const task = $(e.target).closest('li').find('.todo__taskname')
    const form = $(e.target).closest('li').find('form')
    const originalVal = task.text()
    form.find('input').val(originalVal)
    task.hide()
    form.show()
    // 在編輯用表單上監聽 submit 事件
    form.on('submit', (e) => {
      e.preventDefault()
      const val = $(e.target).find('input').val()
      task.text(val)
      task.show()
      form.hide()
    })
  })
  // 刪除功能
  $('#putCardHere').on('click', '.btn-remove', (e) => {
    $(e.target).closest('li').remove()
    // 如果已刪除所有項目：隱藏 todos
    if ($('#putCardHere').find('li').length === 0) {
      $('.card').hide()
    }
  })
  // 標記功能
  $('#putCardHere').on('click', '.custom-checkbox', (e) => {
    const taskTitle = $(e.target).closest('li').find('.todo__taskname')
    const taskCard = $(e.target).closest('li')
    const btns = $(e.target).closest('li').find('.btn-outline-secondary')
    if (taskCard.hasClass('completed')) {
      taskTitle.removeClass('text-decoration-line-through')
      taskCard.removeClass('bg-secondary text-white completed')
      taskCard.addClass('pending')
      btns.removeClass('text-white border-light')
      // 如果沒有已完成項目，就隱藏 clear completed 按鈕
      showHideClearBtn()
    } else {
      taskTitle.addClass('text-decoration-line-through')
      taskCard.addClass('bg-secondary text-white completed')
      taskCard.removeClass('pending')
      btns.addClass('text-white border-light')
      $('#btn-clear').removeClass('d-none')
      // 如果有已完成項目，就顯示 clear completed 按鈕
      showHideClearBtn()
    }
  })

  // 篩選顯示項目：all, active, completed
  $('#btn-all').on('click', () => {
    toggleVisibility('pending', true)
    toggleVisibility('completed', true)
  })
  $('#btn-active').on('click', () => {
    toggleVisibility('pending', true)
    toggleVisibility('completed', false)
  })
  $('#btn-completed').on('click', () => {
    toggleVisibility('pending', false)
    toggleVisibility('completed', true)
  })

  // 清空已完成項目
  $('#btn-clear').on('click', () => {
    $('li[class~="completed"]').remove()
    showHideClearBtn()
    if ($('#putCardHere').find('li').length === 0) {
      $('.card').hide()
    }
  })

  // 啟動拖曳功能
  $(() => {
    $('#putCardHere').sortable()
    $('#putCardHere').disableSelection()
  })
})

function toggleVisibility(status, visibility) {
  if (status === 'completed') {
    if (visibility) {
      $('li[class~="completed"]').removeClass('d-none')
    } else {
      $('li[class~="completed"]').addClass('d-none')
    }
  } else if (status === 'pending') {
    if (visibility) {
      $('li[class~="pending"]').removeClass('d-none')
    } else {
      $('li[class~="pending"]').addClass('d-none')
    }
  }
}

function showHideClearBtn() {
  if (!$('li[class~="completed"]').length) {
    $('#btn-clear').addClass('d-none')
  } else {
    $('#btn-clear').removeClass('d-none')
  }
}

function escapeXSS(str) {
  return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;')
}