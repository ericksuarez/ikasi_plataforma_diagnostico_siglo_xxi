<?php

namespace AppBundle\Controller {

    use BackendBundle\Entity\Course;
    use BackendBundle\Entity\Dimension;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Request;

    /**
     * Created by PhpStorm.
     * User: aldorodriguez
     * Date: 09/11/16
     * Time: 18:01
     */
    class CourseController extends Controller {

        const UNAUTHORIZED = 401;

        /**
         * Devuelve todos los cursos registrados
         * @param Request $request
         * @return mixed
         */
        public function indexAction(Request $request) {
            // Servicio Helpers
            $helpers = $this->get("app.helpers");
            // Servicio del JWT
            $jwt_auth = $this->get("app.jwt_auth");
            // Control de acceso
            $access_control = $this->get("app.access_control");

            $check = $jwt_auth->isAuthorizedToChange($request, $access_control);

            if (is_array($check)) {
                return $helpers->json($check);
            }

            $page = $request->query->getInt("page", 1);
            $paginator = $this->get("knp_paginator");
            $items_per_page = 10;

            $repository = $this->getDoctrine()->getRepository('BackendBundle:Course');

            /** @noinspection PhpUndefinedMethodInspection */
            $query = $repository->createQueryBuilder('t')
                    ->select(['t.id', 't.name', 't.createTime'])
                    ->where('t.status = 1')
                    ->orderBy('t.name', 'ASC')
                    ->getQuery();

            $pagination = $paginator->paginate($query, $page, $items_per_page);
            /** @noinspection PhpUndefinedMethodInspection */
            $total_items = $pagination->getTotalItemCount();

            return $helpers->json([
                        'total_items' => $total_items,
                        'page_actual' => $page,
                        'items_per_page' => $items_per_page,
                        'total_pages' => ceil($total_items / $items_per_page),
                        'data' => $pagination
            ]);
        }

        /**
         * Agrega un nuevo curso
         * @param Request $request
         * @return mixed
         */
        public function createAction(Request $request) {
            $helpers = $this->get("app.helpers");
            $jwtAuth = $this->get("app.jwt_auth");
            $access_control = $this->get("app.access_control");
            $check = $jwtAuth->isAuthorizedToChange($request, $access_control);

            if (is_array($check)) {
                return $helpers->json($check);
            }

            $params = json_decode($request->get("json", null));
            if (!empty($params)) {
                $name = (property_exists($params, "name")) ? $params->name : null;
                $description = (property_exists($params, "description")) ? $params->description : null;
                $link = (property_exists($params, "link")) ? $params->link : null;
                $teacher_function = (property_exists($params, "teacher_function")) ? $params->teacher_function : null;
                $education_level = (property_exists($params, "education_level")) ? $params->education_level : null;
                $specialty = (property_exists($params, "specialty")) ? $params->specialty : null;
                $type_suggestion = (property_exists($params, "type_suggestion")) ? $params->type_suggestion : null;
                $skill_century = (property_exists($params, "skill_century")) ? $params->skill_century : null;
                $area_century = (property_exists($params, "area_century")) ? json_encode($params->area_century) : null;
                $eva_states = (property_exists($params, "eva_states")) ? json_encode($params->eva_states) : null;
                $dimension = (property_exists($params, "dimension")) ? $params->dimension : null;
                $validator = $this->get('validator');
                $course = new Course();
                $course->setName($name);
                $course->setDescription($description);
                $course->setLink($link);
                $course->setEducationLevel($this->getDoctrine()->getRepository('BackendBundle:EducationLevel')->find($education_level));
                $course->setSpeciality($this->getDoctrine()->getRepository('BackendBundle:Speciality')->find($specialty));
                $course->setTeacherFunction($this->getDoctrine()->getRepository('BackendBundle:TeacherFunction')->find($teacher_function));
                $course->setTypeSuggestion($type_suggestion);
                $course->setCreateTime(new \DateTime('now'));
                $course->setDeleteTime(new \DateTime('0000-00-00 00:00:00'));
                $course->setState($eva_states);

                if (!empty($skill_century)) {
                    $course->setSkillCentury($this->getDoctrine()->getRepository('BackendBundle:SkillCentury')->find($skill_century))
                            ->setAreaCenturyIds($area_century);
                }

                if (isset($dimension)) {
                    $course->setDimension($this->getDoctrine()->getRepository(Dimension::class)->find($dimension));
                }


                if (count($validator->validate($course)) == 0) {
                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($course);
                    $manager->flush();

                    if (!empty($eva_states)) {
                        $array_area_century = json_decode($area_century);
                        $array_eva_states = json_decode($eva_states);

                        foreach ($array_area_century as $value_area_century) {
                            foreach ($array_eva_states as $value_eva_states) {
                                $manager = $this->getDoctrine()->getManager();
                                $query = 'INSERT INTO suggested_course (course_id, skill_century_id, area_century_id, state) 
                              VALUES (' . $course->getId() . ',' . $skill_century . ', ' . $value_area_century . ', "' . $value_eva_states . '");';
                                $statement = $manager->getConnection()->prepare($query);
                                $statement->execute();
                            }
                        }
                    }

                    return $helpers->json([
                                'status' => 'success',
                                'title' => 'Guardado',
                                'message' => '¡Los datos se guardaron correctamente!',
                                'id' => $course->getId()
                    ]);
                }
            }

            return $helpers->json(array(
                        'status' => 'error',
                        'title' => 'Error',
                        'message' => 'Error al guardar el curso'
            ));
        }

        /**
         * Devuelve la información de un curso
         * @param Request $request
         * @param $id
         * @return mixed
         */
        public function viewAction(Request $request, $id) {
            $helpers = $this->get("app.helpers");
            $jwtAuth = $this->get("app.jwt_auth");
            $access_control = $this->get("app.access_control");
            $check = $jwtAuth->isAuthorizedToChange($request, $access_control);

            if (is_array($check)) {
                return $helpers->json($check);
            }

            if (empty($id)) {
                return $helpers->json(array(
                            'status' => 'error',
                            'title' => 'Error',
                            'message' => 'Error al obtener el curso'
                ));
            }

            return $helpers->json($this->getDoctrine()->getRepository('BackendBundle:Course')->find($id));
        }

        /**
         * Actualiza la información de un curso
         * @param Request $request
         * @param $id
         * @return mixed
         */
        public function updateAction(Request $request, $id) {
            $helpers = $this->get("app.helpers");
            $jwtAuth = $this->get("app.jwt_auth");
            $access_control = $this->get("app.access_control");
            $check = $jwtAuth->isAuthorizedToChange($request, $access_control);

            if (is_array($check)) {
                return $helpers->json($check);
            }

            $params = json_decode($request->get("json", null));

            if (!empty($params)) {
                $name = (property_exists($params, "name")) ? $params->name : null;
                $description = (property_exists($params, "description")) ? $params->description : null;
                $link = (property_exists($params, "link")) ? $params->link : null;
                $teacher_function = (property_exists($params, "teacher_function")) ? $params->teacher_function : null;
                $education_level = (property_exists($params, "education_level")) ? $params->education_level : null;
                $specialty = (property_exists($params, "specialty")) ? $params->specialty : null;
                $type_suggestion = (property_exists($params, "type_suggestion")) ? $params->type_suggestion : null;
                $skill_century = (property_exists($params, "skill_century")) ? $params->skill_century : null;
                $area_century = (property_exists($params, "area_century")) ? json_encode($params->area_century) : null;
                $eva_states = (property_exists($params, "eva_states")) ? json_encode($params->eva_states) : null;
                $dimension = (property_exists($params, "dimension")) ? $params->dimension : null;
                $validator = $this->get('validator');

                $course = $this->getDoctrine()->getRepository('BackendBundle:Course')->find($id);
                $course->setName($name)
                        ->setDescription($description)
                        ->setLink($link)
                        ->setEducationLevel($this->getDoctrine()->getRepository('BackendBundle:EducationLevel')->find($education_level))
                        ->setSpeciality($this->getDoctrine()->getRepository('BackendBundle:Speciality')->find($specialty))
                        ->setTeacherFunction($this->getDoctrine()->getRepository('BackendBundle:TeacherFunction')->find($teacher_function))
                        ->setTypeSuggestion($type_suggestion)
                        ->setUpdateTime(new \DateTime('now'))
                        ->setState($eva_states);

                if (!empty($skill_century)) {
                    $course->setSkillCentury($this->getDoctrine()->getRepository('BackendBundle:SkillCentury')->find($skill_century))
                            ->setAreaCenturyIds($area_century);
                }

                if (isset($dimension)) {
                    $course->setDimension($this->getDoctrine()->getRepository(Dimension::class)->find($dimension));
                }

                if (!empty($eva_states)) {
                    $array_area_century = json_decode($area_century);
                    $array_eva_states = json_decode($eva_states);

                    $manager = $this->getDoctrine()->getManager();
                    $query = 'DELETE FROM suggested_course WHERE suggested_course.course_id = ' . $id;
                    $statement = $manager->getConnection()->prepare($query);
                    $statement->execute();

                    foreach ($array_area_century as $value_area_century) {
                        foreach ($array_eva_states as $value_eva_states) {
                            $query = 'INSERT INTO suggested_course (course_id, skill_century_id, area_century_id, state) 
                              VALUES (' . $id . ',' . $skill_century . ', ' . $value_area_century . ', "' . $value_eva_states . '");';
                            $statement = $manager->getConnection()->prepare($query);
                            $statement->execute();
                        }
                    }
                }

                if (count($validator->validate($course)) == 0) {
                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($course);
                    $manager->flush();
                    return $helpers->json([
                                'status' => 'success',
                                'title' => 'Guardado',
                                'message' => '¡Los datos se guardaron correctamente!'
                    ]);
                }
            }

            return $helpers->json(array(
                        'status' => 'error',
                        'title' => 'Error',
                        'message' => 'Error al guardar el curso'
            ));
        }

        /**
         * Devuelve las sugerencias de cursos badado en habilidades de siglo XXI
         * @param Request $request
         * @return mixed
         */
        public function suggestionsAction(Request $request) {
            $helpers = $this->get('app.helpers');
            $jwtAuth = $this->get("app.jwt_auth");
            $suggestions = $this->get('app.suggestions');

            $authorization = $request->headers->get('X-API-KEY');
            $identity = $jwtAuth->checkToken($authorization, true);

            if (!$identity) {
                return $helpers->json(['status' => 'error', 'code' => $this::UNAUTHORIZED, 'message' => 'Unauthorized']);
            }

            return $helpers->json($suggestions->run($identity->teacher_id));
        }

        /**
         * Actuliza la imagen de un curso
         * @param Request $request
         * @param $id
         * @return mixed
         */
        public function uploadAction(Request $request, $id) {
            $helpers = $this->get("app.helpers");
            $jwtAuth = $this->get("app.jwt_auth");
            $access_control = $this->get("app.access_control");
            $check = $jwtAuth->isAuthorizedToChange($request, $access_control);

//            if (is_array($check)) {
//                return $helpers->json($check);
//            }

            if (is_numeric($id)) {
                $manager = $this->getDoctrine()->getManager();
                $course = $this->getDoctrine()->getRepository('BackendBundle:Course')->find($id);

                if (!is_object($course)) {
                    return $helpers->json(['status' => 'error', 'code' => $this::UNAUTHORIZED, 'message' => 'Unauthorized is not at object.']);
                }

                $file = $request->files->get('image', null);

                if (!empty($file)) {
                    $ext = $file->guessExtension();
                    $fileName = time() . "." . $ext;
                    $path = "uploads/courses";
                    $file->move($path, $fileName);
                    /** @noinspection PhpUndefinedMethodInspection */
                    $course->setImage($fileName);

                    $manager->persist($course);
                    $manager->flush();
                    return $helpers->json([
                                'status' => 'success',
                                'title' => 'Guardado',
                                'message' => '¡El archivo se ha subido correctamente!'
                    ]);
                }
            } else {
                $file = $request->files->get('image', null);

                if (!empty($file)) {
                    $set = "";
                    switch ($id) {
                        case "page_header":
                            $ext = 'jpg';
                            $fileName = "page-header." . $ext;
                            $path = "../../assets/images";
                            $file->move($path, $fileName);
                            $set = " page_header = '" . $path . "/" . $fileName ."'";
                            break;
                        case "fundacion":
                            $ext = 'png';
                            $fileName = "fundacion." . $ext;
                            $path = "../../assets/images";
                            $file->move($path, $fileName);
                            $set = " fundacion = '" . $path . "/" . $fileName ."'";
                            break;
                        case "logo_sinadep_footer":
                            $ext = 'png';
                            $fileName = "logo_sinadep_footer." . $ext;
                            $path = "../../assets/images";
                            $file->move($path, $fileName);
                            $set = " logo_sinadep_footer = '" . $path . "/" . $fileName ."'";
                            break;
                        case "logo_sinadep":
                            $ext = 'png';
                            $fileName = "logosinadep." . $ext;
                            $path = "../../assets/images";
                            $file->move($path, $fileName);
                            $set = " logo_sinadep = '" . $path . "/" . $fileName ."'";
                            break;
                        case "mejores_maestros":
                            $ext = 'png';
                            $fileName = "mejores_maestros." . $ext;
                            $path = "../../assets/images";
                            $file->move($path, $fileName);
                            $set = " mejores_maestros = '" . $path . "/" . $fileName ."'";
                            break;
                        default:
                            break;
                    }

                    /** @noinspection PhpUndefinedMethodInspection */
                    $manager = $this->getDoctrine()->getManager();
                    $query = 'UPDATE dashboard SET ' . $set . '  WHERE dashboard.id = 1;';
                    $statement = $manager->getConnection()->prepare($query);
                    $statement->execute();

                    return $helpers->json([
                                'status' => 'success',
                                'title' => 'Guardado',
                                'message' => 'La imagen del Dashboard'
                    ]);
                }
            }

            return $helpers->json([
                        'status' => 'error',
                        'title' => 'Error',
                        'message' => 'Error al guardar la imagen'
            ]);
        }

        /**
         * Agrega un nuevo curso desde un archivo CSV. Proceso Batch
         * @param Request $request
         * @return mixed
         */
        public function createBulkAction(Request $request) {
            $helpers = $this->get("app.helpers");
            $array = $request->getContent();
            $params = json_decode($array);

            if (!empty($params)) {
                $name = (property_exists($params, "name")) ? $params->name : null;
                $description = (property_exists($params, "description")) ? $params->description : null;
                $link = (property_exists($params, "link")) ? $params->link : null;
                $teacher_function = (property_exists($params, "teacher_function")) ? $params->teacher_function : null;
                $education_level = (property_exists($params, "education_level")) ? $params->education_level : null;
                $specialty = (property_exists($params, "specialty")) ? $params->specialty : null;
                $type_suggestion = (property_exists($params, "type_suggestion")) ? $params->type_suggestion : null;
                $skill_century = (property_exists($params, "skill_century")) ? str_replace('"', "", $params->skill_century) : null;
                $area_century = (property_exists($params, "area_century")) ? json_encode($params->area_century) : null;
                $dimension = (property_exists($params, "dimension")) ? $params->dimension : null;
                $validator = $this->get('validator');

                /** @validation teacher_function */
                $repository = $this->getDoctrine()->getRepository('BackendBundle:TeacherFunction');
                $sql_teacher_function = $repository->createQueryBuilder('p')
                        ->select(['p.id', 'p.name'])
                        ->where('p.name = :name')
                        ->setParameter('name', trim($teacher_function))
                        ->getQuery();
                $sql_teacher_function = $sql_teacher_function->getResult();
                if (empty($sql_teacher_function)) {
                    return $helpers->json(array(
                                'status' => 'error',
                                'title' => 'Error',
                                'message' => 'La Funcion del Profesor "' . $teacher_function . '" no existe. Favor de crearla!'
                    ));
                } else {
                    $teacher_function = $sql_teacher_function[0]["id"];
                }

                /** @validation education_level */
                $repository = $this->getDoctrine()->getRepository('BackendBundle:EducationLevel');
                $sql_education_level = $repository->createQueryBuilder('p')
                        ->select(['p.id', 'p.name'])
                        ->where('p.name = :name')
                        ->setParameter('name', trim($education_level))
                        ->getQuery();
                $sql_education_level = $sql_education_level->getResult();
                if (empty($sql_education_level)) {
                    return $helpers->json(array(
                                'status' => 'error',
                                'title' => 'Error',
                                'message' => 'El Nivel de Educación "' . $education_level . '" no existe. Favor de crearlo!'
                    ));
                } else {
                    $education_level = $sql_education_level[0]["id"];
                }

                /** @validation specialty */
                $repository = $this->getDoctrine()->getRepository('BackendBundle:Speciality');
                $sql_specialty = $repository->createQueryBuilder('p')
                        ->select(['p.id', 'p.name'])
                        ->where('p.name = :name')
                        ->setParameter('name', trim($specialty))
                        ->getQuery();
                $sql_specialty = $sql_specialty->getResult();
                if (empty($sql_specialty)) {
                    return $helpers->json(array(
                                'status' => 'error',
                                'title' => 'Error',
                                'message' => 'La Especialidad "' . $specialty . '" no existe. Favor de crearla!'
                    ));
                } else {
                    $specialty = $sql_specialty[0]["id"];
                }

                /** @validation type_suggestion */
                if (trim($type_suggestion) == "POR EVALUACION DIAGNOSTICA" || trim($type_suggestion) == "POR HABILIDAD DEL SIGLO XXI") {
                    $type_suggestion = trim($type_suggestion) == "POR EVALUACION DIAGNOSTICA" ? 1 : 2;
                } else {
                    return $helpers->json(array(
                                'status' => 'error',
                                'title' => 'Error',
                                'message' => 'La Configuración de Sugerencia "' . $type_suggestion . '" no existe. Favor de crearla!'
                    ));
                    $type_suggestion = 0;
                }

                /** @validation skill_century */
                if (!empty($skill_century)) {
                    $repository = $this->getDoctrine()->getRepository('BackendBundle:SkillCentury');
                    $sql_skill_century = $repository->createQueryBuilder('p')
                            ->select(['p.id', 'p.name'])
                            ->where('p.name = :name')
                            ->setParameter('name', trim($skill_century))
                            ->getQuery();
                    $sql_skill_century = $sql_skill_century->getResult();
                    if (empty($sql_skill_century)) {
                        return $helpers->json(array(
                                    'status' => 'error',
                                    'title' => 'Error',
                                    'message' => 'La Habilidad "' . $skill_century . '" no existe. Favor de crearla!'
                        ));
                    } else {
                        $skill_century = $sql_skill_century[0]["id"];
                    }
                } else {
                    return $helpers->json(array(
                                'status' => 'error',
                                'title' => 'Error',
                                'message' => 'La Habilidad no puede estar vacia.'
                    ));
                }

                /** @validation area_century */
                if (!empty($area_century)) {
                    $area_century = str_replace('"AUTO-DIRECCION"', "1", $area_century);
                    $area_century = str_replace('"CONCIENCIA GLOBAL"', "2", $area_century);
                    $area_century = str_replace('"LIDERAZGO"', "3", $area_century);
                }

                /** @validation course_exist */
                $rep = $this->getDoctrine()->getRepository('BackendBundle:Course');
                $course_exist = $rep->findOneBy(['name' => $name]);
                if (!empty($course_exist)) {
                    return $helpers->json([
                                'status' => 'error',
                                'title' => 'Error',
                                'message' => 'Curso ' . $name . ' ya existe.'
                    ]);
                }

                if (!empty($sql_teacher_function) && !empty($sql_education_level) && !empty($sql_specialty) && $type_suggestion != 0) {

                    $course = new Course();
                    $course->setName($name)
                            ->setDescription($description)
                            ->setLink($link)
                            ->setEducationLevel($this->getDoctrine()->getRepository('BackendBundle:EducationLevel')->find($education_level))
                            ->setSpeciality($this->getDoctrine()->getRepository('BackendBundle:Speciality')->find($specialty))
                            ->setTeacherFunction($this->getDoctrine()->getRepository('BackendBundle:TeacherFunction')->find($teacher_function))
                            ->setTypeSuggestion($type_suggestion)
                            ->setCreateTime(new \DateTime('now'));

                    if (!empty($skill_century)) {
                        $course->setSkillCentury($this->getDoctrine()->getRepository('BackendBundle:SkillCentury')->find($skill_century))
                                ->setAreaCenturyIds($area_century);
                    }

                    if (isset($dimension)) {
                        $course->setDimension($this->getDoctrine()->getRepository(Dimension::class)->find($dimension));
                    }


                    if (count($validator->validate($course)) == 0) {
                        $manager = $this->getDoctrine()->getManager();
                        $manager->persist($course);
                        $manager->flush();
                        return $helpers->json([
                                    'status' => 'success',
                                    'title' => 'Guardado',
                                    'message' => 'Curso ' . $course->getName()
                        ]);
                    }
                }
            }
        }

        /**
         * Devuelve un listado con todas las especialidades
         * @return mixed
         */
        public function deactivatedAction(Request $request, $id) {
            $helpers = $this->get("app.helpers");

            $manager = $this->getDoctrine()->getManager();
            $course = $manager->getRepository('BackendBundle:Course')->find($id);

            if (!is_object($course)) {
                return $helpers->json(['status' => 'error', 'code' => $this::UNAUTHORIZED, 'message' => 'Unauthorized']);
            }

            $validator = $this->get('validator');

            $course->setDeleteTime(new \DateTime('now'));
            $course->setStatus(0);

            if (count($validator->validate($course)) == 0) {
                /** @noinspection PhpUndefinedMethodInspection */
                $query = $this->getDoctrine()->getManager();
                $query->persist($course);
                $query->flush();

                return $helpers->json(array(
                            'status' => 200,
                            'title' => '¡Correcto!',
                            'message' => 'Se ha desactivado correctamente el elemento.'
                ));
                ;
            }

            return $helpers->json(array(
                        'status' => 'error',
                        'title' => 'Error',
                        'message' => 'Error al tratar de desactivar, el registro.'
            ));
            ;
        }

        /**
         * Devuelve todos los cursos registrados
         * @param Request $request
         * @return mixed
         */
        public function searchAction(Request $request, $id) {
            // Servicio Helpers
            $helpers = $this->get("app.helpers");

            $page = $request->query->getInt("page", 1);
            $paginator = $this->get("knp_paginator");
            $items_per_page = 10;

            $repository = $this->getDoctrine()->getRepository('BackendBundle:Course');

            /** @noinspection PhpUndefinedMethodInspection */
            $query = $repository->createQueryBuilder('t')
                    ->select(['t.id', 't.name', 't.createTime', 't.status', 't.deleteTime']);

            switch ($id) {
                case 0:
                    $query->where('t.status = 0');
                    break;
                case 1:
                    $query->where('t.status = 1');
                    break;

                default:
                    break;
            }

            $query->orderBy('t.name', 'ASC')
                    ->getQuery();

            $pagination = $paginator->paginate($query, $page, $items_per_page);
            /** @noinspection PhpUndefinedMethodInspection */
            $total_items = $pagination->getTotalItemCount();

            return $helpers->json([
                        'total_items' => $total_items,
                        'page_actual' => $page,
                        'items_per_page' => $items_per_page,
                        'total_pages' => ceil($total_items / $items_per_page),
                        'data' => $pagination
            ]);
        }

    }

}