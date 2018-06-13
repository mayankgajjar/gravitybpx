<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * @author : mjenisha
 */

$config = array(
  'users/add' => array(
    array(
      'field' => 'username',
      'label' => 'Username',
      'rules' => 'required|is_unique[users.username]'
    ),
    array(
      'field' => 'password',
      'label' => 'Password',
      'rules' => 'required|min_length[6]'
    ),
    array(
      'field' => 'email',
      'label' => 'Email',
      'rules' => 'required|valid_email|is_unique[users.email]'
    ),
    array(
      'field' => 'first_name',
      'label' => 'First Name',
      'rules' => 'required|alpha'
    ),
    array(
      'field' => 'last_name',
      'label' => 'Last Name',
      'rules' => 'required|alpha'
    ),
  ),
  'users/edit' => array(
    array(
      'field' => 'username',
      'label' => 'Username',
      'rules' => 'required|is_unique[users.username]'
    ),
    array(
      'field' => 'email',
      'label' => 'Email',
      'rules' => 'required|valid_email|is_unique[users.email]'
    ),
    array(
      'field' => 'first_name',
      'label' => 'First Name',
      'rules' => 'required|alpha'
    ),
    array(
      'field' => 'last_name',
      'label' => 'Last Name',
      'rules' => 'required|alpha'
    ),
  ),
  'usergroups/add' => array(
    array(
      'field' => 'name',
      'label' => 'Name',
      'rules' => 'required|is_unique[user_groups.name]'
    )
  )
);



