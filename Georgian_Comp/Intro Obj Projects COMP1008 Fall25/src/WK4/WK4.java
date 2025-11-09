public class WK4 {

    public class Grade{

        private double percentage;
        private String letter;
        private static final String[] ALLOWED_GRADE_LETTERS = {"A", "B", "C", "D", "F"};

        public Grade(){
            setLetter();
        }

        public Double getPercentage(){
            return this.percentage;
        }
        // first line of method = method header = method signature
        // access_olevel return_data_type nameOfMethod([dt1 arg1, dt2 argN])
        public void setPercentage(double percentage){
            if(percentage >= 0 && percentage <= 100){
                this.percentage = percentage;
                setLetter();
            }
        }

        public String getLetter(){
            return letter;
        }

        private void setLetter(){

            if(percentage >= 80){
                letter = ALLOWED_GRADE_LETTERS[0];
            }
            else if(percentage >= 70){
                letter = ALLOWED_GRADE_LETTERS[1];
            }
            else if(percentage >= 60){
                letter = ALLOWED_GRADE_LETTERS[2];
            }
            else if(percentage >= 50){
                letter = ALLOWED_GRADE_LETTERS[3];
            }
            else if(percentage >= 40){
                letter = ALLOWED_GRADE_LETTERS[4];
            }

        }

    }

}
