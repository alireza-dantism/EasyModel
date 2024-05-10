# Loop refinement of an existing model
from modeller import *
from modeller.automodel import *
import sys

log.verbose()
env = Environ()

Vorodi   = sys.argv[1]
Vorodi   = Vorodi.split(' ')

chainName = Vorodi[0]
ResiduFrom =  Vorodi[1]
ResiduTo = Vorodi[2]
PdbFileName =  Vorodi[3]

# directories for input atom files
env.io.atom_files_directory = ['.', '../atom_files']

# Create a new class based on 'LoopModel' so that we can redefine
# select_loop_atoms (necessary)
class MyLoop(LoopModel):
    # This routine picks the residues to be refined by loop modeling
    def select_loop_atoms(self):
        # 10 residue insertion 
        return Selection(self.residue_range(ResiduFrom+':'+chainName, ResiduTo+':'+chainName))

m = MyLoop(env,
           inimodel=PdbFileName, # initial model of the target
           sequence='Model')          # code of the target

m.loop.starting_model= 1           # index of the first loop model 
m.loop.ending_model  = 10          # index of the last loop model
m.loop.md_level = refine.very_fast # loop refinement method; this yields
                                   # models quickly but of low quality;
                                   # use refine.slow for better models

m.make()

