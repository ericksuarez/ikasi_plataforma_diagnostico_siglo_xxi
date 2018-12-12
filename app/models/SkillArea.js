"use strict";
var SkillArea = (function () {
    function SkillArea(skill_century_id, name, min_vulnerable, max_vulnerable, min_competent, max_competent, min_optimum, max_optimum) {
        this.skill_century_id = skill_century_id;
        this.name = name;
        this.min_vulnerable = min_vulnerable;
        this.max_vulnerable = max_vulnerable;
        this.min_competent = min_competent;
        this.max_competent = max_competent;
        this.min_optimum = min_optimum;
        this.max_optimum = max_optimum;
    }
    return SkillArea;
}());
exports.SkillArea = SkillArea;
//# sourceMappingURL=SkillArea.js.map