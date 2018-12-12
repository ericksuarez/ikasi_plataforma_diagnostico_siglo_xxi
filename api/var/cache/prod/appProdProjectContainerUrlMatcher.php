<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appProdProjectContainerUrlMatcher.
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appProdProjectContainerUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher {

    /**
     * Constructor.
     */
    public function __construct(RequestContext $context) {
        $this->context = $context;
    }

    public function match($pathinfo) {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;


        if (rtrim($pathinfo, '/') === '') {
            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'HEAD'));
                goto not_default_index;
            }

            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'default_index');
            }

            return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::indexAction',  '_route' => 'default_index',);
        }
        not_default_index:

        // default_demo
        if ($pathinfo === '/demo') {
            if ($this->context->getMethod() != 'POST') {
                $allow[] = 'POST';
                goto not_default_demo;
            }

            return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::demoAction',  '_route' => 'default_demo',);
        }
        not_default_demo:

        // default:login
        if ($pathinfo === '/login') {
            if ($this->context->getMethod() != 'POST') {
                $allow[] = 'POST';
                goto not_defaultlogin;
            }

            return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::loginAction',  '_route' => 'default:login',);
        }
        not_defaultlogin:

        // default:profile
        if ($pathinfo === '/profile') {
            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'HEAD'));
                goto not_defaultprofile;
            }

            return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::profileAction',  '_route' => 'default:profile',);
        }
        not_defaultprofile:

        if (0 === strpos($pathinfo, '/user')) {
            // user_register
            if ($pathinfo === '/user/register') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_user_register;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\UserController::registerAction',  '_route' => 'user_register',);
            }
            not_user_register:

            // user_activate
            if ($pathinfo === '/user/activate') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_user_activate;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\UserController::activateAction',  '_route' => 'user_activate',);
            }
            not_user_activate:

            // user_password_recovery
            if ($pathinfo === '/user/password-recovery') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_user_password_recovery;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\UserController::passwordRecoveryAction',  '_route' => 'user_password_recovery',);
            }
            not_user_password_recovery:

            if (0 === strpos($pathinfo, '/user/change-')) {
                if (0 === strpos($pathinfo, '/user/change-password')) {
                    // user_change_password_token
                    if ($pathinfo === '/user/change-password-token') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_user_change_password_token;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\UserController::changePasswordTokenAction',  '_route' => 'user_change_password_token',);
                    }
                    not_user_change_password_token:

                    // user_change_password
                    if ($pathinfo === '/user/change-password') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_user_change_password;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\UserController::changePasswordAction',  '_route' => 'user_change_password',);
                    }
                    not_user_change_password:

                }

                // user_change_email
                if ($pathinfo === '/user/change-email') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_user_change_email;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\UserController::changeEmailAction',  '_route' => 'user_change_email',);
                }
                not_user_change_email:

            }

            // user_update_profile
            if ($pathinfo === '/user/update-profile') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_user_update_profile;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\UserController::updateProfileAction',  '_route' => 'user_update_profile',);
            }
            not_user_update_profile:

            if (0 === strpos($pathinfo, '/user/ch')) {
                // user_check_curp
                if ($pathinfo === '/user/check-curp') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_user_check_curp;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\UserController::checkCurpAction',  '_route' => 'user_check_curp',);
                }
                not_user_check_curp:

                // user_change_home
                if ($pathinfo === '/user/change-home') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_user_change_home;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\UserController::changeHomeAction',  '_route' => 'user_change_home',);												  																								 											
                }
                not_user_change_home:

																																		  
            }

            // user_text_home
            if ($pathinfo === '/user/text-home') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_user_text_home;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\UserController::textHomeAction',  '_route' => 'user_text_home',);
            }
            not_user_text_home:

            // user_get_home
            if (0 === strpos($pathinfo, '/user/get-home') && preg_match('#^/user/get\\-home(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_user_get_home;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'user_get_home')), array (  '_controller' => 'AppBundle\\Controller\\UserController::getHomeAction',  'id' => NULL,));
            }
            not_user_get_home:

        }

        if (0 === strpos($pathinfo, '/specialty')) {
            // specialty_list
            if ($pathinfo === '/specialty/list') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_specialty_list;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\SpecialtyController::listAction',  '_route' => 'specialty_list',);
            }
            not_specialty_list:

            // specialty_all
            if ($pathinfo === '/specialty/all') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_specialty_all;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\SpecialtyController::allAction',  '_route' => 'specialty_all',);
            }
            not_specialty_all:

            // specialty_create
            if ($pathinfo === '/specialty/create') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_specialty_create;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\SpecialtyController::createAction',  '_route' => 'specialty_create',);
            }
            not_specialty_create:

            // specialty_update
            if (0 === strpos($pathinfo, '/specialty/update') && preg_match('#^/specialty/update(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_specialty_update;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'specialty_update')), array (  '_controller' => 'AppBundle\\Controller\\SpecialtyController::updateAction',  'id' => NULL,));
            }
            not_specialty_update:

            // specialty_delete
            if (0 === strpos($pathinfo, '/specialty/delete') && preg_match('#^/specialty/delete(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_specialty_delete;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'specialty_delete')), array (  '_controller' => 'AppBundle\\Controller\\SpecialtyController::deleteAction',  'id' => NULL,));
            }
            not_specialty_delete:

        }

        if (0 === strpos($pathinfo, '/teacher-function')) {
            // teacher_function_list
            if ($pathinfo === '/teacher-function/list') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_teacher_function_list;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\TeacherFunctionController::listAction',  '_route' => 'teacher_function_list',);
            }
            not_teacher_function_list:

            // teacher_function_all
            if ($pathinfo === '/teacher-function/all') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_teacher_function_all;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\TeacherFunctionController::allAction',  '_route' => 'teacher_function_all',);
            }
            not_teacher_function_all:

            // teacher_function_create
            if ($pathinfo === '/teacher-function/create') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_teacher_function_create;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\TeacherFunctionController::createAction',  '_route' => 'teacher_function_create',);
            }
            not_teacher_function_create:

            // teacher_function_update
            if (0 === strpos($pathinfo, '/teacher-function/update') && preg_match('#^/teacher\\-function/update(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_teacher_function_update;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'teacher_function_update')), array (  '_controller' => 'AppBundle\\Controller\\TeacherFunctionController::updateAction',  'id' => NULL,));
            }
            not_teacher_function_update:

            // teacher_function_delete
            if (0 === strpos($pathinfo, '/teacher-function/delete') && preg_match('#^/teacher\\-function/delete(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_teacher_function_delete;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'teacher_function_delete')), array (  '_controller' => 'AppBundle\\Controller\\TeacherFunctionController::deleteAction',  'id' => NULL,));
            }
            not_teacher_function_delete:

        }

        if (0 === strpos($pathinfo, '/education-level')) {
            // education_level_list
            if ($pathinfo === '/education-level/list') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_education_level_list;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\EducationLevelController::listAction',  '_route' => 'education_level_list',);
            }
            not_education_level_list:

            // education_level_all
            if ($pathinfo === '/education-level/all') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_education_level_all;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\EducationLevelController::allAction',  '_route' => 'education_level_all',);
            }
            not_education_level_all:

            // education_level_create
            if ($pathinfo === '/education-level/create') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_education_level_create;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\EducationLevelController::createAction',  '_route' => 'education_level_create',);
            }
            not_education_level_create:

            // education_level_update
            if (0 === strpos($pathinfo, '/education-level/update') && preg_match('#^/education\\-level/update(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_education_level_update;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'education_level_update')), array (  '_controller' => 'AppBundle\\Controller\\EducationLevelController::updateAction',  'id' => NULL,));
            }
            not_education_level_update:

            // education_level_delete
            if (0 === strpos($pathinfo, '/education-level/delete') && preg_match('#^/education\\-level/delete(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_education_level_delete;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'education_level_delete')), array (  '_controller' => 'AppBundle\\Controller\\EducationLevelController::deleteAction',  'id' => NULL,));
            }
            not_education_level_delete:

        }

        // contact_send
        if ($pathinfo === '/contact/send') {
            if ($this->context->getMethod() != 'POST') {
                $allow[] = 'POST';
                goto not_contact_send;
            }

            return array (  '_controller' => 'AppBundle\\Controller\\ContactController::sendAction',  '_route' => 'contact_send',);
        }
        not_contact_send:						   
        if (0 === strpos($pathinfo, '/teacher')) {
            // teacher_all
            if ($pathinfo === '/teacher/all') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_teacher_all;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\TeacherController::allAction',  '_route' => 'teacher_all',);
            }
            not_teacher_all:

            // teacher_profile
            if ($pathinfo === '/teacher/profile') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_teacher_profile;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\TeacherController::profileAction',  '_route' => 'teacher_profile',);
            }
            not_teacher_profile:

            // teacher_update_user
            if ($pathinfo === '/teacher/update-user') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_teacher_update_user;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\TeacherController::updateUserAction',  '_route' => 'teacher_update_user',);
            }
            not_teacher_update_user:

            // teacher_preregister
            if ($pathinfo === '/teacher/list-preregister') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_teacher_preregister;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\TeacherController::listPreregisterAction',  '_route' => 'teacher_preregister',);
            }
            not_teacher_preregister:

            // teacher_import
            if ($pathinfo === '/teacher/import') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_teacher_import;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\TeacherController::importAction',  '_route' => 'teacher_import',);
            }
            not_teacher_import:

            // teacher_delete
            if (0 === strpos($pathinfo, '/teacher/delete')  && preg_match('#^/teacher/delete(?:/(?P<id>[^/]++))(?:/(?P<opcion>[^/]++))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_teacher_delete;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'teacher_delete')), array (  '_controller' => 'AppBundle\\Controller\\TeacherController::deleteAction',  'id' => NULL, 'opcion' => NULL,));
            }
            not_teacher_delete:

            // teacher_allfullname
            if ($pathinfo === '/teacher/allfullname') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_teacher_allfullname;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\TeacherController::allfullnameAction',  '_route' => 'teacher_allfullname',);
            }
            not_teacher_allfullname:

        }

        if (0 === strpos($pathinfo, '/course')) {
            // course_all
            if ($pathinfo === '/course/index') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_course_all;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\CourseController::indexAction',  '_route' => 'course_all',);
            }
            not_course_all:

            // course_create
            if ($pathinfo === '/course/create') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_course_create;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\CourseController::createAction',  '_route' => 'course_create',);
            }
            not_course_create:

            // course_view
            if (0 === strpos($pathinfo, '/course/view') && preg_match('#^/course/view(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_course_view;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'course_view')), array (  '_controller' => 'AppBundle\\Controller\\CourseController::viewAction',  'id' => NULL,));
            }
            not_course_view:

            // course_update
            if (0 === strpos($pathinfo, '/course/update') && preg_match('#^/course/update(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_course_update;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'course_update')), array (  '_controller' => 'AppBundle\\Controller\\CourseController::updateAction',  'id' => NULL,));
            }
            not_course_update:

            // course_suggestions
            if ($pathinfo === '/course/suggestions') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_course_suggestions;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\CourseController::suggestionsAction',  '_route' => 'course_suggestions',);
            }
            not_course_suggestions:

            // course_upload_image
            if (0 === strpos($pathinfo, '/course/upload-image') && preg_match('#^/course/upload\\-image/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_course_upload_image;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'course_upload_image')), array (  '_controller' => 'AppBundle\\Controller\\CourseController::uploadAction',));
            }
            not_course_upload_image:

            // course_createBulk
            if ($pathinfo === '/course/createBulk') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_course_createBulk;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\CourseController::createBulkAction',  '_route' => 'course_createBulk',);
            }
            not_course_createBulk:

            // course_deactivated
            if (0 === strpos($pathinfo, '/course/deactivated') && preg_match('#^/course/deactivated(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_course_deactivated;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'course_deactivated')), array (  '_controller' => 'AppBundle\\Controller\\CourseController::deactivatedAction',  'id' => NULL,));
            }
            not_course_deactivated:

            // course_search
            if (0 === strpos($pathinfo, '/course/search') && preg_match('#^/course/search(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_course_search;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'course_search')), array (  '_controller' => 'AppBundle\\Controller\\CourseController::searchAction',  'id' => NULL,));
            }
            not_course_search:

        }

        if (0 === strpos($pathinfo, '/skill-century')) {
            // skill_century_create
            if ($pathinfo === '/skill-century/create') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_skill_century_create;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\SkillCenturyController::createAction',  '_route' => 'skill_century_create',);
            }
            not_skill_century_create:

            // skill_century_edit
            if (0 === strpos($pathinfo, '/skill-century/edit') && preg_match('#^/skill\\-century/edit(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_skill_century_edit;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'skill_century_edit')), array (  '_controller' => 'AppBundle\\Controller\\SkillCenturyController::editAction',  'id' => NULL,));
            }
            not_skill_century_edit:

            // skill_century_list
            if ($pathinfo === '/skill-century/list') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_skill_century_list;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\SkillCenturyController::listAction',  '_route' => 'skill_century_list',);
            }
            not_skill_century_list:

            // skill_century_delete
            if (0 === strpos($pathinfo, '/skill-century/delete') && preg_match('#^/skill\\-century/delete(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_skill_century_delete;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'skill_century_delete')), array (  '_controller' => 'AppBundle\\Controller\\SkillCenturyController::deleteAction',  'id' => NULL,));
            }
            not_skill_century_delete:
			
			// skill_century_deleteQuestion
            if (0 === strpos($pathinfo, '/skill-century/deleteQuestion') && preg_match('#^/skill\\-century/deleteQuestion(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_skill_century_deleteQuestion;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'skill_century_deleteQuestion')), array (  '_controller' => 'AppBundle\\Controller\\SkillCenturyController::deleteQuestionAction',  'id' => NULL,));
            }
            not_skill_century_deleteQuestion:

            // skill_century_view
            if (0 === strpos($pathinfo, '/skill-century/view') && preg_match('#^/skill\\-century/view(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_skill_century_view;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'skill_century_view')), array (  '_controller' => 'AppBundle\\Controller\\SkillCenturyController::viewAction',  'id' => NULL,));
            }
            not_skill_century_view:

        }

        if (0 === strpos($pathinfo, '/area-century')) {
            // area_century_new
            if ($pathinfo === '/area-century/new') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_area_century_new;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\AreaCenturyController::newAction',  '_route' => 'area_century_new',);
            }
            not_area_century_new:

            // area_century_edit
            if (0 === strpos($pathinfo, '/area-century/edit') && preg_match('#^/area\\-century/edit(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_area_century_edit;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'area_century_edit')), array (  '_controller' => 'AppBundle\\Controller\\AreaCenturyController::editAction',  'id' => NULL,));
            }
            not_area_century_edit:

            // area_century_list
            if (0 === strpos($pathinfo, '/area-century/list') && preg_match('#^/area\\-century/list(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_area_century_list;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'area_century_list')), array (  '_controller' => 'AppBundle\\Controller\\AreaCenturyController::listAction',  'id' => NULL,));
            }
            not_area_century_list:

            if (0 === strpos($pathinfo, '/area-century/de')) {
                // area_century_detail
                if (0 === strpos($pathinfo, '/area-century/detail') && preg_match('#^/area\\-century/detail(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_area_century_detail;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'area_century_detail')), array (  '_controller' => 'AppBundle\\Controller\\AreaCenturyController::detailAction',  'id' => NULL,));
                }
                not_area_century_detail:

                // area_century_deactivate
                if (0 === strpos($pathinfo, '/area-century/deactivate') && preg_match('#^/area\\-century/deactivate(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_area_century_deactivate;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'area_century_deactivate')), array (  '_controller' => 'AppBundle\\Controller\\AreaCenturyController::deactivateAction',  'id' => NULL,));
                }
                not_area_century_deactivate:

            }

        }

        if (0 === strpos($pathinfo, '/category')) {
            // category_new
            if ($pathinfo === '/category/new') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_category_new;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\CategoryController::newAction',  '_route' => 'category_new',);
            }
            not_category_new:

            // category_edit
            if (0 === strpos($pathinfo, '/category/edit') && preg_match('#^/category/edit(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_category_edit;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'category_edit')), array (  '_controller' => 'AppBundle\\Controller\\CategoryController::editAction',  'id' => NULL,));
            }
            not_category_edit:

            // category_deactivate
            if (0 === strpos($pathinfo, '/category/deactivate') && preg_match('#^/category/deactivate(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_category_deactivate;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'category_deactivate')), array (  '_controller' => 'AppBundle\\Controller\\CategoryController::deactivateAction',  'id' => NULL,));
            }
            not_category_deactivate:

            // category_list
            if ($pathinfo === '/category/list') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_category_list;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\CategoryController::listAction',  'id' => NULL,  '_route' => 'category_list',);
            }
            not_category_list:
			
			// category_delete
            if (0 === strpos($pathinfo, '/category/delete') && preg_match('#^/category/delete(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'GET') {
                    $allow[] = 'POST';
                    goto not_category_delete;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'category_delete')), array (  '_controller' => 'AppBundle\\Controller\\CategoryController::deleteAction',  'id' => NULL,));
            }
            not_category_delete:

        }

        if (0 === strpos($pathinfo, '/answer-category')) {
            // answer_category_create
            if ($pathinfo === '/answer-category/create') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_answer_category_create;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\AnswerCategoryController::createAction',  '_route' => 'answer_category_create',);
            }
            not_answer_category_create:

            // anwswer_category_edit
            if (0 === strpos($pathinfo, '/answer-category/edit') && preg_match('#^/answer\\-category/edit(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_anwswer_category_edit;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'anwswer_category_edit')), array (  '_controller' => 'AppBundle\\Controller\\AnswerCategoryController::editAction',  'id' => NULL,));
            }
            not_anwswer_category_edit:

            if (0 === strpos($pathinfo, '/answer-category/de')) {
                // answer_category_detail
                if (0 === strpos($pathinfo, '/answer-category/detail') && preg_match('#^/answer\\-category/detail(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_answer_category_detail;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'answer_category_detail')), array (  '_controller' => 'AppBundle\\Controller\\AnswerCategoryController::detailAction',  'id' => NULL,));
                }
                not_answer_category_detail:

                // answer_category_deactivate
                if (0 === strpos($pathinfo, '/answer-category/deactivate') && preg_match('#^/answer\\-category/deactivate(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_answer_category_deactivate;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'answer_category_deactivate')), array (  '_controller' => 'AppBundle\\Controller\\AnswerCategoryController::deactivateAction',  'id' => NULL,));
                }
                not_answer_category_deactivate:

            }

            // answer_category_list
            if (0 === strpos($pathinfo, '/answer-category/list') && preg_match('#^/answer\\-category/list(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_answer_category_list;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'answer_category_list')), array (  '_controller' => 'AppBundle\\Controller\\AnswerCategoryController::listAction',  'id' => NULL,));
            }
            not_answer_category_list:
			
			// answer_category_delete
            if (0 === strpos($pathinfo, '/answer-category/delete') && preg_match('#^/answer\\-category/delete(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_answer_category_delete;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'answer_category_delete')), array (  '_controller' => 'AppBundle\\Controller\\AnswerCategoryController::deleteAction',  'id' => NULL,));
            }
            not_answer_category_delete:

        }

        if (0 === strpos($pathinfo, '/inee')) {
            // inee_create_dimension
            if ($pathinfo === '/inee/create-dimension') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_inee_create_dimension;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\IneeController::createDimensionAction',  '_route' => 'inee_create_dimension',);
            }
            not_inee_create_dimension:

            // inee_get_dimension
            if (0 === strpos($pathinfo, '/inee/get-dimension') && preg_match('#^/inee/get\\-dimension(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_inee_get_dimension;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'inee_get_dimension')), array (  '_controller' => 'AppBundle\\Controller\\IneeController::getDimensionAction',  'id' => NULL,));
            }
            not_inee_get_dimension:

            // inee_create_parameter
            if (0 === strpos($pathinfo, '/inee/create-parameter') && preg_match('#^/inee/create\\-parameter(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_inee_create_parameter;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'inee_create_parameter')), array (  '_controller' => 'AppBundle\\Controller\\IneeController::createParameterAction',  'id' => NULL,));
            }
            not_inee_create_parameter:

            // inee_get_parameter
            if (0 === strpos($pathinfo, '/inee/get-parameter') && preg_match('#^/inee/get\\-parameter(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_inee_get_parameter;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'inee_get_parameter')), array (  '_controller' => 'AppBundle\\Controller\\IneeController::getParameterAction',  'id' => NULL,));
            }
            not_inee_get_parameter:

            // inee_create_indicator
            if (0 === strpos($pathinfo, '/inee/create-indicator') && preg_match('#^/inee/create\\-indicator(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_inee_create_indicator;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'inee_create_indicator')), array (  '_controller' => 'AppBundle\\Controller\\IneeController::createIndicatorAction',  'id' => NULL,));
            }
            not_inee_create_indicator:

            // inee_filter_dimension
            if (0 === strpos($pathinfo, '/inee/filter-dimension') && preg_match('#^/inee/filter\\-dimension(?:/(?P<educationLevelId>[^/]++)(?:/(?P<teacherFunctionId>[^/]++))?)?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_inee_filter_dimension;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'inee_filter_dimension')), array (  '_controller' => 'AppBundle\\Controller\\IneeController::filterDimensionAction',  'educationLevelId' => NULL,  'teacherFunctionId' => NULL,));
            }
            not_inee_filter_dimension:

            // inee_import
            if ($pathinfo === '/inee/import') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_inee_import;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\IneeController::importAction',  '_route' => 'inee_import',);
            }
            not_inee_import:

            if (0 === strpos($pathinfo, '/inee/list-')) {
                // inee_list_dimension
                if (0 === strpos($pathinfo, '/inee/list-dimension') && preg_match('#^/inee/list\\-dimension(?:/(?P<educationLevelId>[^/]++)(?:/(?P<teacherFunctionId>[^/]++))?)?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_inee_list_dimension;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'inee_list_dimension')), array (  '_controller' => 'AppBundle\\Controller\\IneeController::listDimensionAction',  'educationLevelId' => NULL,  'teacherFunctionId' => NULL,));
                }
                not_inee_list_dimension:

                // inee_list_parameter
                if (0 === strpos($pathinfo, '/inee/list-parameter') && preg_match('#^/inee/list\\-parameter(?:/(?P<dimensionId>[^/]++))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_inee_list_parameter;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'inee_list_parameter')), array (  '_controller' => 'AppBundle\\Controller\\IneeController::listParameterAction',  'dimensionId' => NULL,));
                }
                not_inee_list_parameter:

                // inee_list_indicator
                if (0 === strpos($pathinfo, '/inee/list-indicator') && preg_match('#^/inee/list\\-indicator/(?P<parameterId>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_inee_list_indicator;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'inee_list_indicator')), array (  '_controller' => 'AppBundle\\Controller\\IneeController::listIndicatorAction',  'indicatorId' => NULL,));
                }
                not_inee_list_indicator:
            }
			
			// inee_delete_parameter
			if (0 === strpos($pathinfo, '/inee/delete-parameter') && preg_match('#^/inee/delete\\-parameter(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
				if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
					$allow = array_merge($allow, array('GET', 'HEAD'));
					goto not_inee_delete_parameter;
				}

				return $this->mergeDefaults(array_replace($matches, array('_route' => 'inee_delete_parameter')), array (  '_controller' => 'AppBundle\\Controller\\IneeController::deleteParameterAction',  'id' => NULL,));
			}
			not_inee_delete_parameter:
			
			// inee_update_parameter
            if (0 === strpos($pathinfo, '/inee/update-parameter') && preg_match('#^/inee/update\\-parameter(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_inee_update_parameter;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'inee_update_parameter')), array (  '_controller' => 'AppBundle\\Controller\\IneeController::updateParameterAction',  'id' => NULL,));
            }
            not_inee_update_parameter:
			
			// inee_delete_indicator
			if (0 === strpos($pathinfo, '/inee/delete-indicator') && preg_match('#^/inee/delete\\-indicator(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
				if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
					$allow = array_merge($allow, array('GET', 'HEAD'));
					goto not_inee_delete_indicator;
				}

				return $this->mergeDefaults(array_replace($matches, array('_route' => 'inee_delete_indicator')), array (  '_controller' => 'AppBundle\\Controller\\IneeController::deleteIndicatorAction',  'id' => NULL,));
			}
			not_inee_delete_indicator:
			
			// inee_update_indicator
            if (0 === strpos($pathinfo, '/inee/update-indicator') && preg_match('#^/inee/update\\-indicator(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_inee_update_indicator;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'inee_update_indicator')), array (  '_controller' => 'AppBundle\\Controller\\IneeController::updateIndicatorAction',  'id' => NULL,));
            }
            not_inee_update_indicator:
			
			// inee_delete_dimension
			if (0 === strpos($pathinfo, '/inee/delete-dimension') && preg_match('#^/inee/delete\\-dimension(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
				if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
					$allow = array_merge($allow, array('GET', 'HEAD'));
					goto not_inee_delete_dimension;
				}

				return $this->mergeDefaults(array_replace($matches, array('_route' => 'inee_delete_dimension')), array (  '_controller' => 'AppBundle\\Controller\\IneeController::deleteDimensionAction',  'id' => NULL,));
			}
			not_inee_delete_dimension:
			
			// inee_graph_dashboard
			if (0 === strpos($pathinfo, '/inee/getGraphDashboard') && preg_match('#^/inee/getGraphDashboard(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
				if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
					$allow = array_merge($allow, array('GET', 'HEAD'));
					goto not_graph_dashboard;
				}

				return $this->mergeDefaults(array_replace($matches, array('_route' => 'graph_dashboard')), array (  '_controller' => 'AppBundle\\Controller\\IneeController::getGraphDashboardAction',  'id' => NULL,));
			}
			not_graph_dashboard:

        }

        if (0 === strpos($pathinfo, '/questionary-century')) {
            // questionary_century_new
            if ($pathinfo === '/questionary-century/new') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_questionary_century_new;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\QuestionCenturyController::newAction',  '_route' => 'questionary_century_new',);
            }
            not_questionary_century_new:

            if (0 === strpos($pathinfo, '/questionary-century/list')) {
                // questionary_century_list
                if (preg_match('#^/questionary\\-century/list(?:/(?P<areaId>[^/]++)(?:/(?P<categoryId>[^/]++))?)?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_questionary_century_list;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'questionary_century_list')), array (  '_controller' => 'AppBundle\\Controller\\QuestionCenturyController::listAction',  'categoryId' => NULL,  'areaId' => NULL,));
                }
                not_questionary_century_list:

                // questionary_century_list_by_area
                if (0 === strpos($pathinfo, '/questionary-century/list-by-area') && preg_match('#^/questionary\\-century/list\\-by\\-area(?:/(?P<areaId>[^/]++)(?:/(?P<userId>[^/]++))?)?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_questionary_century_list_by_area;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'questionary_century_list_by_area')), array (  '_controller' => 'AppBundle\\Controller\\QuestionCenturyController::getQuestionByAreaAction',  'areaId' => NULL,  'userId' => NULL,));
                }
                not_questionary_century_list_by_area:

            }

            // questionary_century_import_csv
            if (0 === strpos($pathinfo, '/questionary-century/import-csv') && preg_match('#^/questionary\\-century/import\\-csv(?:/(?P<areaId>[^/]++)(?:/(?P<categoryId>[^/]++)(?:/(?P<replace>[^/]++))?)?)?$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_questionary_century_import_csv;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'questionary_century_import_csv')), array (  '_controller' => 'AppBundle\\Controller\\QuestionCenturyController::importQuestionaryAction',  'areaId' => NULL,  'categoryId' => NULL,  'replace' => NULL,));
            }
            not_questionary_century_import_csv:

        }

        if (0 === strpos($pathinfo, '/answer-')) {
            if (0 === strpos($pathinfo, '/answer-teacher-century')) {
                // teacher_answer_century_new
                if ($pathinfo === '/answer-teacher-century/saveAnswer') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_teacher_answer_century_new;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\TeacherAnswerCenturyController::saveAnswerAction',  '_route' => 'teacher_answer_century_new',);
                }
                not_teacher_answer_century_new:

                // teacher_answer_century_results
                if (0 === strpos($pathinfo, '/answer-teacher-century/getResult') && preg_match('#^/answer\\-teacher\\-century/getResult(?:/(?P<userId>[^/]++))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_teacher_answer_century_results;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'teacher_answer_century_results')), array (  '_controller' => 'AppBundle\\Controller\\TeacherAnswerCenturyController::getResultsAction',  'userId' => '= null',));
                }
                not_teacher_answer_century_results:

                // teacher_answer_century_save_image
                if ($pathinfo === '/answer-teacher-century/saveImage') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_teacher_answer_century_save_image;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\TeacherAnswerCenturyController::saveImageAction',  '_route' => 'teacher_answer_century_save_image',);
                }
                not_teacher_answer_century_save_image:

                if (0 === strpos($pathinfo, '/answer-teacher-century/export-result')) {
                    // teacher_answer_century_export_result
                    if (preg_match('#^/answer\\-teacher\\-century/export\\-result(?:/(?P<teacherId>[^/]++))?$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_teacher_answer_century_export_result;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'teacher_answer_century_export_result')), array (  '_controller' => 'AppBundle\\Controller\\TeacherAnswerCenturyController::exportResultAction',  'teacherId' => NULL,));
                    }
                    not_teacher_answer_century_export_result:

                    // teacher_answer_century_export_result_to_excel
                    if (0 === strpos($pathinfo, '/answer-teacher-century/export-result-to-excel') && preg_match('#^/answer\\-teacher\\-century/export\\-result\\-to\\-excel(?:/(?P<teacherId>[^/]++))?$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_teacher_answer_century_export_result_to_excel;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'teacher_answer_century_export_result_to_excel')), array (  '_controller' => 'AppBundle\\Controller\\TeacherAnswerCenturyController::exportResultToExcelAction',  'teacherId' => NULL,));
                    }
                    not_teacher_answer_century_export_result_to_excel:

                }

            }

            if (0 === strpos($pathinfo, '/answer-question-century')) {
                // app_answer_question_century_list
                if (0 === strpos($pathinfo, '/answer-question-century/list') && preg_match('#^/answer\\-question\\-century/list(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_app_answer_question_century_list;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_answer_question_century_list')), array (  '_controller' => 'AppBundle\\Controller\\AnswerQuestionCenturyController::listAction',  'id' => NULL,));
                }
                not_app_answer_question_century_list:

                // app_answer_question_century_new
                if (0 === strpos($pathinfo, '/answer-question-century/new') && preg_match('#^/answer\\-question\\-century/new(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_app_answer_question_century_new;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_answer_question_century_new')), array (  '_controller' => 'AppBundle\\Controller\\AnswerQuestionCenturyController::newAction',  'id' => NULL,));
                }
                not_app_answer_question_century_new:

            }

        }

        if (0 === strpos($pathinfo, '/evaluation-inee')) {
            // evaluation_inee_create
            if ($pathinfo === '/evaluation-inee/create') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_evaluation_inee_create;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\EvaluationIneeController::createAction',  '_route' => 'evaluation_inee_create',);
            }
            not_evaluation_inee_create:

            // evaluation_inee_import
            if ($pathinfo === '/evaluation-inee/import') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_evaluation_inee_import;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\EvaluationIneeController::importAction',  '_route' => 'evaluation_inee_import',);
            }
            not_evaluation_inee_import:

            // evaluation_inee_filter_evaluation
            if (0 === strpos($pathinfo, '/evaluation-inee/filter-evaluation') && preg_match('#^/evaluation\\-inee/filter\\-evaluation(?:/(?P<educationLevelId>[^/]++)(?:/(?P<teacherFunctionId>[^/]++))?)?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_evaluation_inee_filter_evaluation;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'evaluation_inee_filter_evaluation')), array (  '_controller' => 'AppBundle\\Controller\\EvaluationIneeController::filterEvaluationAction',  'educationLevelId' => NULL,  'teacherFunctionId' => NULL,));
            }
            not_evaluation_inee_filter_evaluation:

            // evaluation_inee_delete
            if (0 === strpos($pathinfo, '/evaluation-inee/delete') && preg_match('#^/evaluation\\-inee/delete(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_evaluation_inee_delete;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'evaluation_inee_delete')), array (  '_controller' => 'AppBundle\\Controller\\EvaluationIneeController::deleteAction',  'id' => NULL,));
            }
            not_evaluation_inee_delete:

            // evaluation_inee_view
            if (0 === strpos($pathinfo, '/evaluation-inee/view') && preg_match('#^/evaluation\\-inee/view(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_evaluation_inee_view;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'evaluation_inee_view')), array (  '_controller' => 'AppBundle\\Controller\\EvaluationIneeController::viewAction',  'id' => NULL,));
            }
            not_evaluation_inee_view:

            // evaluation_inee_update
            if (0 === strpos($pathinfo, '/evaluation-inee/update') && preg_match('#^/evaluation\\-inee/update(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_evaluation_inee_update;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'evaluation_inee_update')), array (  '_controller' => 'AppBundle\\Controller\\EvaluationIneeController::updateAction',  'id' => NULL,));
            }
            not_evaluation_inee_update:

        }

        if (0 === strpos($pathinfo, '/questionnaire-inee')) {
            if (0 === strpos($pathinfo, '/questionnaire-inee/get-')) {
                // questionnaire_inee_get
                if (0 === strpos($pathinfo, '/questionnaire-inee/get-questions') && preg_match('#^/questionnaire\\-inee/get\\-questions/(?P<dimensionId>[^/]++)/(?P<educationLevel>[^/]++)/(?P<teacherFunction>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_questionnaire_inee_get;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'questionnaire_inee_get')), array (  '_controller' => 'AppBundle\\Controller\\QuestionnaireIneeController::getQuestionsAction',  'dimensionId' => NULL,  'educationLevelId' => NULL,  'teacherFunctionId' => NULL,));
                }
                not_questionnaire_inee_get:

                // questionnaire_inee_dimension
                if ($pathinfo === '/questionnaire-inee/get-dimensions') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_questionnaire_inee_dimension;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\QuestionnaireIneeController::getDimensionsAction',  '_route' => 'questionnaire_inee_dimension',);
                }
                not_questionnaire_inee_dimension:

            }

            if (0 === strpos($pathinfo, '/questionnaire-inee/save')) {
                // questionnaire_inee_save
                if ($pathinfo === '/questionnaire-inee/save') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_questionnaire_inee_save;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\QuestionnaireIneeController::saveAction',  '_route' => 'questionnaire_inee_save',);
                }
                not_questionnaire_inee_save:

                // questionnaire_inee_save_image
                if ($pathinfo === '/questionnaire-inee/save-image') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_questionnaire_inee_save_image;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\QuestionnaireIneeController::saveImageAction',  '_route' => 'questionnaire_inee_save_image',);
                }
                not_questionnaire_inee_save_image:

            }

            if (0 === strpos($pathinfo, '/questionnaire-inee/export-')) {
                // questionnaire_inee_export_pdf
                if (0 === strpos($pathinfo, '/questionnaire-inee/export-pdf') && preg_match('#^/questionnaire\\-inee/export\\-pdf(?:/(?P<teacherId>[^/]++))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_questionnaire_inee_export_pdf;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'questionnaire_inee_export_pdf')), array (  '_controller' => 'AppBundle\\Controller\\QuestionnaireIneeController::exportPdfAction',  'teacherId' => NULL,));
                }
                not_questionnaire_inee_export_pdf:

                // questionnaire_inee_export_excel
                if (0 === strpos($pathinfo, '/questionnaire-inee/export-excel') && preg_match('#^/questionnaire\\-inee/export\\-excel(?:/(?P<teacherId>[^/]++))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_questionnaire_inee_export_excel;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'questionnaire_inee_export_excel')), array (  '_controller' => 'AppBundle\\Controller\\QuestionnaireIneeController::exportExcelAction',  'teacherId' => NULL,));
                }
                not_questionnaire_inee_export_excel:																			   																																																				 																					   																		   																		  					 

            }

            // questionnaire_inee_reset_evaluation_inee
            if (0 === strpos($pathinfo, '/questionnaire-inee/reset-evaluation-inee') && preg_match('#^/questionnaire\\-inee/reset\\-evaluation\\-inee(?:/(?P<teacherId>[^/]++))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_questionnaire_inee_reset_evaluation_inee;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'questionnaire_inee_reset_evaluation_inee')), array (  '_controller' => 'AppBundle\\Controller\\QuestionnaireIneeController::resetEvaluationIneeAction',  'teacherId' => NULL,));
            }
            not_questionnaire_inee_reset_evaluation_inee:

        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
