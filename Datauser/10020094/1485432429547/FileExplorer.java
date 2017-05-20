//package lap03;

/**
 *
 * @author MaThiVanAnh
 */
public class FileExplorer {
    /** root of Folder*/
    private Folder root;
    /** currentFolder of FileExplorer*/
    private Folder currentFolder;
    public FileExplorer(){
        root = new Folder();
        currentFolder = root;
    }
    public FileExplorer( Folder root) {
        this.root = root;
        currentFolder = this.root;
    }
    /** return the currentFolder*/
    public Folder getCurrentFolder (){
        return currentFolder;
    }
    /**return the root*/
    public Folder getRoot (){
        return root;
    }
    /**@param currentFolder the currentFolder to set*/
    public void setCurrentFolder( Folder currentFolder) {
        this.currentFolder = currentFolder;
    }
    /**@param root the root to set*/
    public void setRoot( Folder root) {
        this.root = root;
    }
    /** hien thi cac folder con cua currentFolder*/
    public void explore() {
        Folder[] children = currentFolder.getChildren();
        for(int i = 0; i < children.length;i++) {
            System.out.println( children[i]);
        }
    }
    /**add a new folder into the currentFolder
     * @param aNewFolder 
     *@return false or true
     */
   public Boolean addANewFolder(Folder aNewFolder) {
       Boolean result = false;
       
       /** kiem tra xem co trung ten voi folder truoc khong*/
       Folder[] children = currentFolder.getChildren();
       for (Folder folder : children) {
           if(aNewFolder.getName(). equals(folder.getName()))
               return false;
       }
       for(int i = 0; i< children.length;i++) {
           if(children[i] == null) {
               children[i] = aNewFolder;
               return true;   
           }
           break;
       }
       return result;
   }
   
   /**Select one folder in currentFolder
    * @param n la vi tri delete
    * @return folder o vi tri can delete
    */
   public Folder selectAFolder(Integer index) {
       Folder result = null;
       Folder[] children = currentFolder.getChildren();
       if((index > -1)  && (children.length > index)){
           result = children[index];
       }
       return result;
   }
   public Boolean deleteFolder(Folder folder) {
       Folder[] children = currentFolder.getChildren();
        
     }
}
       
       
   
   
   
   
   
       
   
  
    

